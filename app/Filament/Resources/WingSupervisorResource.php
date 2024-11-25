<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WingSupervisorResource\Pages;
use App\Filament\Resources\WingSupervisorResource\RelationManagers;
use App\Models\Building;
use App\Models\Professor;
use App\Models\Wing;
use App\Models\WingSupervisor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class WingSupervisorResource extends Resource
{
    protected static ?string $model = WingSupervisor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Responsable de beca';

    protected static ?string $pluralLabel = 'Responsables de beca';

    protected static ?string $navigationGroup = 'Recursos humanos';
    
    protected static ?int $navigationSort = 2;
    
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Residence_Manager');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Profesor')
                    ->schema([    
                        Forms\Components\TextInput::make('professor.name')
                            ->required()
                            ->label('Nombre')
                            ->reactive()
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->professor) {
                                    $professorname = $record->professor->name;
                                    $set('professor.name', $professorname);
                                }
                            })
                            ->visible(fn (callable $get) => !$get('existing_P')),
                        Forms\Components\TextInput::make('professor.dni')
                            ->label('CI')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $existingdni = Professor::where('dni', $state)->first();
                                
                                if ($existingdni) {
                                    $set('dni_exists', true); // Marcamos que el correo existe
                                } else {
                                    $set('dni_exists', false); // Si no existe, marcamos que no existe
                                }
                            })
                            ->helperText(fn (callable $get) => $get('dni_exists') ? 'Warning! This DNI already exists. Please change it.' : null)
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->professor) {
                                    $professordni = $record->professor->dni;
                                    $set('professor.dni', $professordni);
                                }
                            })
                            ->visible(fn (callable $get) => !$get('existing_P')),
                            
                        Forms\Components\Select::make('professor_id')
                            ->label('Profesor')
                            ->placeholder('Seleccione un profesor')
                            ->relationship('professor', 'name')
                            ->options(function () { 
                                // Aquí obtienes a los profesores que no están asociados
                                return Professor::whereDoesntHave('yearleadprofessor') // Asegúrate de que no están en la tabla de PPAs
                                    ->whereDoesntHave('groupadvisor')  // Asegúrate de que no están en la tabla de PGs
                                    ->whereDoesntHave('dean') // Asegúrate de que no están en la tabla de Decanos
                                    ->whereDoesntHave('wingSupervisor') // Asegúrate de que no están en la tabla de Supervisores de Ala
                                    ->pluck('name', 'id'); // Obtener solo el nombre y el id
                            })
                            ->disabled(fn (callable $get) => !$get('existing_P')) // Solo habilitado si existing_P es verdadero
                            ->visible(fn (callable $get) => $get('existing_P'))
                            ->preload()
                            ->live()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('existing_P')
                            ->label('Existing Professor')
                            ->reactive(),
                ])
                    ->collapsible()
                    ->columns(2),

                Forms\Components\Section::make('Asignación del responsable de beca')
                    ->schema([
                        Forms\Components\Select::make('campus')
                                ->label('Sede')
                                ->options([
                                    'Universitaria' => 'Universitaria',
                                    'Félix Varela' => 'Félix Varela',
                                    'Manuel Fajardo' => 'Manuel Fajardo',
                                ])
                                ->searchable()
                                ->preload()
                                ->live() // Reactivo para cambiar los edificios disponibles
                                ->required()
                                ->afterStateUpdated(function (Set $set) 
                                    { 
                                        $set('building_id', null);
                                        $set('wing_id', null);
                                    }
                                )
                                ->afterStateHydrated(function (Set $set, $record) {
                                    if ($record && $record->wing) {
                                        $buildingCampus = $record->wing->building->campus;
                                        $set('campus', $buildingCampus);
                                    }
                                })
                                ->placeholder('Select a campus'),

                            // Campo para seleccionar el edificio (filtrado por sede)
                            Forms\Components\Select::make('building_id')
                                ->label('Edificio')
                                ->options(fn (Get $get): Collection => Building::query()
                                                ->where('campus', $get('campus'))
                                                ->pluck('name', 'id')
                                )->searchable()
                                ->preload()
                                ->live() // Reactivo para cambiar las alas disponibles
                                ->required()
                                ->afterStateUpdated(function (Set $set) 
                                    { 
                                        $set('wing_id', null);
                                    }
                                )
                                ->afterStateHydrated(function (Set $set, $record) {
                                    if ($record && $record->wing) {
                                        $buildingName = $record->wing->building->name;
                                        $set('building_id', $buildingName);
                                    }
                                })
                                ->placeholder('Seleccione un edificio'),
                    Forms\Components\Select::make('wing_id')
                        ->required()
                        ->label('Ala')
                        ->placeholder('Seleccione un ala')
                        ->relationship('wing', 'name')
                        ->options(fn (Get $get): Collection => Wing::query()
                                    ->where('building_id', $get('building_id'))
                                    ->pluck('name', 'id')
                                    )
                        ->searchable()
                        ->preload()
                        ->live(),
                    ])->collapsible()
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professor.name')
                    ->label('Responsable')
                    ->sortable(),
                Tables\Columns\TextColumn::make('wing.building.name')
                    ->label('Edificio')
                    ->sortable(),
                Tables\Columns\TextColumn::make('wing.name')
                    ->label('Ala')
                    ->sortable(),
                
            ])
            
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWingSupervisors::route('/'),
            'create' => Pages\CreateWingSupervisor::route('/create'),
            'edit' => Pages\EditWingSupervisor::route('/{record}/edit'),
        ];
    }
}

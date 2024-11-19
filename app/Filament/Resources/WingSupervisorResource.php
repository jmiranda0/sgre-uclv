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
                            ->visible(fn (callable $get) => !$get('existing_P'))
                            ->maxLength(255)
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->professor) {
                                    $professorname = $record->professor->name;
                                    $set('professor.name', $professorname);
                                }
                            }),
                        Forms\Components\TextInput::make('professor.dni')
                            ->required()
                            ->unique('professors', 'dni',null,ignoreRecord: true)
                            ->maxLength(11)
                            ->visible(fn (callable $get) => !$get('existing_P'))
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
                        }),
                        Forms\Components\Select::make('professor_id')
                            ->relationship('professor', 'name')
                            ->disabled(fn (callable $get) => !$get('existing_P')) // Solo habilitado si existing_P es verdadero
                            ->visible(fn (callable $get) => $get('existing_P'))
                            ->preload()
                            ->live()
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('existing_P')
                            ->label('existing Person')
                            ->reactive(),
                    ])
                    ->collapsible()
                    ->columns(2),


            Forms\Components\Section::make('Asignación del responsable de beca')
                ->schema([
                    Forms\Components\Select::make('campus')
                            ->label('Campus')
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
                            ->label('Building')
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
                            ->placeholder('Select a building'),
                Forms\Components\Select::make('wing_id')
                    ->required()
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('wing.building.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('wing.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

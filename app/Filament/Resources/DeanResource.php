<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeanResource\Pages;
use App\Filament\Resources\DeanResource\RelationManagers;
use App\Models\Dean;
use App\Models\Professor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class DeanResource extends Resource
{
    protected static ?string $model = Dean::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Decano';

    protected static ?string $pluralLabel = 'Decanos';

    protected static ?string $navigationGroup = 'Recursos humanos';

    protected static ?int $navigationSort = 3;
    
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') ; 
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
                                ->relationship('professor', 'name')
                                ->label('Profesor')
                                ->placeholder('Seleccione un profesor')
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
                                ->label('Profesor existente')
                                ->reactive(),
                        ])
                        ->collapsible()
                        ->columns(2),
                Forms\Components\Section::make('Asignación de facultad')
                    ->schema([    
                            Forms\Components\Select::make('faculty_id')
                            ->label('Facultad')
                            ->placeholder('Seleccione una facultad')
                            ->relationship('faculty', 'name')
                            ->required(),
                    ])
            ]);
    }
   
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professor.name')
                    ->label('Decano')
                    ->sortable(),
                Tables\Columns\TextColumn::make('faculty.name')
                    ->label('Facultad')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('Ver Decano')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Editar Decano')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Eliminar Decano')
                ->label('')
                ->size('xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Information')
                    ->schema([
                        TextEntry::make('professor.name')
                            ->label('Nombre'),  
                        TextEntry::make('professor.dni')
                            ->label('CI'), 
                        TextEntry::make('faculty.name')
                            ->label('Facultad'),
                    ])->columns(2)
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
            'index' => Pages\ListDeans::route('/'),
            'create' => Pages\CreateDean::route('/create'),
            'edit' => Pages\EditDean::route('/{record}/edit'),
        ];
    }
}

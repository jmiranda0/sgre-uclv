<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfessorResource\Pages;
use App\Filament\Resources\ProfessorResource\RelationManagers;
use App\Models\Professor;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfessorResource extends Resource
{
    protected static ?string $model = Professor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Profesor';
    
    protected static ?string $pluralLabel = 'Profesores';

    protected static ?string $navigationGroup = 'Recursos humanos';

    protected static ?int $navigationSort = 1;

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
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('dni')
                            ->label('CI')
                            ->required()
                            //->unique('professors', 'dni',null,ignoreRecord: true)
                            ->maxLength(11)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                            $existingdni = Professor::where('dni', $state)->first();
                            
                            if ($existingdni) {
                                $set('dni_exists', true); // Marcamos que el correo existe
                            } else {
                                $set('dni_exists', false); // Si no existe, marcamos que no existe
                            }
                        })
                        ->helperText(fn (callable $get) => $get('dni_exists') ? 'Warning! This DNI already exists. Please change it.' : null),


                        
                        Forms\Components\Toggle::make('existing_user')
                            ->label('Usuario existente')
                            ->reactive(),
                    ])
                    ->collapsible()
                    ->columns(2),
                Forms\Components\Section::make('Usuario Asociado')
                    ->schema([
                        
                        Forms\Components\Select::make('user_id')
                        ->label('Usuario')
                        ->relationship('user', 'email')
                        ->placeholder('Selecciona un usuario')
                        ->searchable()
                        ->disabled(fn (callable $get) => !$get('existing_user')) // Solo habilitado si existing_user es verdadero
                        ->visible(fn (callable $get) => $get('existing_user'))
                        ->options(function (callable $get) {
                            // Filtra los usuarios que NO están asociados a un profesor o estudiante
                            return User::whereDoesntHave('professor') 
                                            ->whereDoesntHave('student')
                                            ->pluck('email', 'id');
                        })->columnSpanFull(),
    
                        Forms\Components\TextInput::make('user.email')
                        ->label( "Correo del usuario")
                        ->email()
                        //->unique('users', 'email', ignoreRecord: true)
                        ->visible(fn (callable $get) => !$get('existing_user'))
                        ->reactive() // Se reactiva al cambiar el valor
                        ->afterStateUpdated(function (callable $set, $state, callable $get) {
                            $existingUser = User::where('email', $state)->first();
                            
                            if ($existingUser) {
                                $set('user_id', $existingUser->id); // Si el usuario ya existe, asignamos su ID al campo user_id
                                $set('email_exists', true); // Marcamos que el correo existe
                            } else {
                                $set('email_exists', false); // Si no existe, marcamos que no existe
                            }
                        })
                        ->helperText(fn (callable $get) => $get('email_exists') ? 'Warning! A user with this email already exists. Please select an existing user or create a new email.' : null)
                        ->afterStateHydrated(function (Set $set, $record) {
                            if ($record && $record->user) {
                                $email = $record->user->email;
                                $set('user.email', $email);
                            }
                        }),


                    Forms\Components\TextInput::make('user.password')
                        ->label("Contraseña del usuario")
                        ->password()
                        ->visible(fn (callable $get) => !$get('existing_user'))
                        ->minLength(8), // Puedes ajustar la longitud mínima de la contraseña
                ])
                    ->columns(2)
                    ->collapsible(),        

            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni')
                    ->label('CI')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.roles.name')
                    ->label('Rol')
                    ->formatStateUsing(fn ($state) => $state ? $state : '?')
                    ->searchable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('Ver profesor')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Editar profesor')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Eliminar profesor')
                ->label('')
                ->size('xl'),
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
            'index' => Pages\ListProfessors::route('/'),
            'create' => Pages\CreateProfessor::route('/create'),
            'edit' => Pages\EditProfessor::route('/{record}/edit'),
        ];
    }
}

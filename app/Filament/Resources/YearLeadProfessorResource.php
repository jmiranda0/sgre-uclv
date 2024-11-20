<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YearLeadProfessorResource\Pages;
use App\Filament\Resources\YearLeadProfessorResource\RelationManagers;
use App\Models\Career;
use App\Models\CareerYear;
use App\Models\Faculty;
use App\Models\Professor;
use App\Models\YearLeadProfessor;
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
use PhpParser\Node\Expr\Cast\Array_;
use Ramsey\Collection\Collection as CollectionCollection;

class YearLeadProfessorResource extends Resource
{
    protected static ?string $model = YearLeadProfessor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Faculty_Dean');
    }
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        return static::getModel()::query()
            ->visibleForUser($user); // Aplicamos el scope definido
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Profesor')
                    ->schema([    
                            Forms\Components\TextInput::make('professor.name')
                                ->required()
                                ->label('Name')
                                ->reactive()
                                ->afterStateHydrated(function (Set $set, $record) {
                                    if ($record && $record->professor) {
                                        $professorname = $record->professor->name;
                                        $set('professor.name', $professorname);
                                    }
                                })
                                ->visible(fn (callable $get) => !$get('existing_P')),

                            Forms\Components\TextInput::make('professor.dni')
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
                
                
                Forms\Components\Section::make('Datos del Profesor')
                    ->schema([
                            Forms\Components\Select::make('faculty_id')
                                ->label('Faculty')
                                ->visible(auth()->user()->hasRole('GM'))
                                ->placeholder('Select a Faculty')
                                ->options(Faculty::all()->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function(Set $set){ 
                                    $set('career_id', null);
                                    $set('career_year_id', null);
                                }) 
                                ->afterStateHydrated(function (Set $set, $record) {
                                    if ($record && $record->careerYear) {
                                        $careername = $record->careerYear->career->faculty->name;
                                        $set('faculty_id', $careername);
                                    }
                                }),
                            Forms\Components\Select::make('career_id')
                                ->label('career')
                                ->placeholder('Select a career')
                                ->options( auth()->user()->hasRole('GM')? 
                                            fn (Get $get): Collection => Career::query()
                                                ->where('faculty_id', $get('faculty_id'))
                                                ->pluck('name','id')
                                            :  
                                            fn (): Collection => Career::query()
                                                ->where('faculty_id', auth()->user()->professor->dean->faculty->id)
                                                ->pluck('name','id')
                                    )
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn(Set $set) => $set('career_year_id', null)) 
                                ->afterStateHydrated(function (Set $set, $record) {
                                    if ($record && $record->careerYear) {
                                        $careername = $record->careerYear->career->name;
                                        $set('career_id', $careername);
                                    }
                                }),
                            Forms\Components\Select::make('career_year_id')
                                ->label('academic year')
                                ->relationship(name:'careerYear', titleAttribute: 'name')
                                ->options(fn (Get $get): Collection => CareerYear::query()
                                                        ->where('career_id', $get('career_id'))
                                                        ->pluck('name','id')
                                                )
                                ->searchable()
                                ->preload()
                                ->live()
                                ->placeholder('Select an acacemic year')
                                ->required(),
                    ])
                        ->collapsible()
                        ->columns(2),            
            ]);
            
    }
     
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professor.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('careerYear.name')
                    ->numeric()
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
                Tables\Actions\ViewAction::make()
                    ->tooltip('View Year Lead Professor')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\EditAction::make()
                    ->tooltip('Edit Year Lead Professor')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Delete Year Lead Professor')
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
            'index' => Pages\ListYearLeadProfessors::route('/'),
            'create' => Pages\CreateYearLeadProfessor::route('/create'),
            'edit' => Pages\EditYearLeadProfessor::route('/{record}/edit'),
        ];
    }
}

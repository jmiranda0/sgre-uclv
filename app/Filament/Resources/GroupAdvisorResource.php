<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupAdvisorResource\Pages;
use App\Filament\Resources\GroupAdvisorResource\RelationManagers;
use App\Models\career;
use App\Models\CareerYear;
use App\Models\Group;
use App\Models\GroupAdvisor;
use App\Models\Municipality;
use App\Models\Professor;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class GroupAdvisorResource extends Resource
{
    protected static ?string $model = GroupAdvisor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Profesor Gía';

    protected static ?string $pluralLabel = 'Profesores Gía';

    protected static ?string $navigationGroup = 'Recursos humanos';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Faculty_Dean');
    }
    
    public static function canViewAny(): bool
    {
        return request()->user()->can('view_group_supervisors');
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
                                ->required()
                                ->label('CI')
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
                                ->label('Selecciona un profesor')
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
                    


                    Forms\Components\Section::make('Asignación del grupo')
                        ->schema([              
                            Forms\Components\Select::make('career_id')
                                ->label('Carrera')
                                ->placeholder('Selecciona la carrera')
                                ->options(Career::all()->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(fn(Set $set) => $set('career_year_id', null)) 
                                ->afterStateHydrated(function (Set $set, $record) {
                                    if ($record && $record->group) {
                                        $careername = $record->group->careerYear->career->name;
                                        $set('career_id', $careername);
                                    }
                                }),
                            Forms\Components\Select::make('career_year_id')
                                ->label('Año académico')
                                ->options(fn (Get $get): Collection => CareerYear::query()
                                                        ->where('career_id', $get('career_id'))
                                                        ->pluck('name','id')
                                                )
                                ->searchable()
                                ->preload()
                                ->live()
                                ->placeholder('Selecciona el año académico'),

                            Forms\Components\Select::make('group_id')
                                ->label('Grupo')
                                ->relationship(name:'group',titleAttribute:'group_number')
                                ->placeholder('Selecciona el grupo')
                                ->options(fn (Get $get): Collection => Group::query()
                                                        ->where('career_year_id', $get('career_year_id'))
                                                        ->pluck('group_number','id')
                                                )
                                ->live()
                                ->preload()
                                ->required(),
                        ])    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professor.name')
                    ->label('Profesor Gía')
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.group_number')
                    ->label('Grupo')
                    ->sortable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->tooltip('Ver Profesor Gía')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\EditAction::make()
                    ->tooltip('Editar Profesor Gía')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Eliminar Profesor Gía')
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
                            ->label('Name'),  
                        TextEntry::make('professor.dni')
                            ->label('Dni'), 
                        TextEntry::make('group.careerYear.career.faculty.name')
                            ->label('Faculty'),
                        TextEntry::make('group.careerYear.career.name')
                            ->label('Career'),
                        TextEntry::make('group.group_number')
                            ->label('Group'),
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
            'index' => Pages\ListGroupAdvisors::route('/'),
            'create' => Pages\CreateGroupAdvisor::route('/create'),
            'edit' => Pages\EditGroupAdvisor::route('/{record}/edit'),
        ];
    }
}

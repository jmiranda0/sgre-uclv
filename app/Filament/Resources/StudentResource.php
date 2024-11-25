<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Building;
use App\Models\Career;
use App\Models\CareerYear;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Room;
use App\Models\Student;
use App\Models\Wing;
use Doctrine\DBAL\Query;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

use function Livewire\wrap;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $label = 'Estudiante';

    protected static ?string $pluralLabel = 'Estudiantes';

    protected static ?int $navigationSort = 1;
    
    public static function canAccess(): bool
    {
        return !auth()->user()->hasRole('Student');
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
            Section::make('Información Personal')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->label('Apellido')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('dni')
                        ->required()
                        ->label('CI')
                        ->unique('students', 'dni', ignoreRecord: true)
                        ->maxLength(11)
                        ->rules(['digits:11', 'regex:/^[0-9]{11}$/'])
                        ,
                    Forms\Components\TextInput::make('scholarship_card')
                        ->label('Carnet de Estudiante')
                        ->required()
                        ->unique('students', 'scholarship_card', ignoreRecord: true)
                        ->maxLength(255),
                    // Toggle para determinar si es extranjero
                    Forms\Components\Toggle::make('is_foreign')
                        ->label('Es extrangero')
                        ->required()
                        ->live() // Reactivo para cambiar los campos visibles
                        ->afterStateUpdated(function (callable $set, $state) {
                            // Mostrar u ocultar campos según si es extranjero
                            $set('country_visible', $state);
                            $set('province_municipality_visible', !$state);
                    }),

                ])->columns(2),
            
            Section::make('Localidad')
                ->schema([
                        
                        // Campo de selección para el país (visible si es extranjero)
                        Forms\Components\Select::make('country_id')
                            ->label('País')
                            ->relationship(name: 'country', titleAttribute: 'name') // Consulta de países
                            ->searchable()
                            ->preload()
                            ->live()
                            ->visible(fn (callable $get) => $get('is_foreign')) // Solo se muestra si es extranjero
                            ->placeholder('Selecciona el país')
                            ->columnSpanFull(),

                        // Campo de selección para la provincia (visible si no es extranjero)
                        Forms\Components\Select::make('province_id')
                            ->label('Provincia')
                            ->options(Province::all()->pluck('name', 'id')) // Consulta de provincias
                            ->searchable()
                            ->preload()
                            ->label('Selecciona la provincia')
                            ->live() 
                            ->afterStateUpdated(fn(Set $set) => $set('municipality_id', null))
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->municipality) {
                                    $provincename = $record->municipality->province->name;
                                    $set('province_id', $provincename);
                                }
                            })
                            ->visible(fn (callable $get) => !$get('is_foreign')) // Visible solo si no es extranjero
                            , 
                        
                        // Campo de selección para el municipio, filtrado por provincia
                        Forms\Components\Select::make('municipality_id')
                            ->label('Municipio')
                            ->relationship(name: 'municipality', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->options(fn (Get $get): Collection => Municipality::query()
                                            ->where('province_id', $get('province_id'))
                                            ->pluck('name','id')
                                    )
                            ->visible(fn (callable $get) => !$get('is_foreign')) // Visible solo si no es extranjero
                            ->placeholder('Selecciona el municipio'),

                ])->columns(2),

            Section::make('Información Academica')
                ->schema([
                        // Campo de selección para la facultad
                        Forms\Components\Select::make('faculty_id')
                                ->label('Facultad')
                                ->options(Faculty::all()->pluck('name', 'id')) // Consulta de facultad
                                ->searchable()
                                ->preload()
                                ->live() 
                                ->afterStateUpdated(fn(Set $set) => $set('career_id', null))
                                ->afterStateHydrated(function (Set $set, $record) {
                                        if ($record && $record->careeryear) {
                                            $facultyname = $record->careeryear->career->faculty->name;
                                            $set('faculty_id', $facultyname);
                                        }
                                    })
                                    ->hidden(fn () => auth()->user()->hasRole('Faculty_Dean')),
                        // Campo de selección para la carrera
                        Forms\Components\Select::make('career_id')
                                ->label('Carera')
                                ->searchable()
                                ->preload()
                                ->live()
                                ->options( auth()->user()->hasRole('Faculty_Dean')?
                                            fn (): Collection => Career::query()
                                                ->where('faculty_id', auth()->user()->professor->dean->faculty->id)
                                                ->pluck('name', 'id')
                                            :
                                            fn (Get $get): Collection => Career::query()
                                                ->where('faculty_id', $get('faculty_id'))
                                                ->pluck('name','id')
                                        )
                                ->afterStateUpdated(fn(Set $set) => $set('career_year_id', null))
                                
                                ->placeholder('Selecciona una carrera')
                                ->afterStateHydrated(function (Set $set, $record) {
                                        if ($record && $record->careeryear) {
                                            $careername = $record->careeryear->career->name;
                                            $set('career_id', $careername);
                                        }
                                }),
                        // Campo de selección para el año academico
                        Forms\Components\Select::make('career_year_id')
                                ->label('Año académico')
                                ->preload()
                                ->searchable()
                                ->live()
                                ->options(fn (Get $get): Collection => CareerYear::query()
                                                ->where('career_id', $get('career_id'))
                                                ->pluck('name','id')
                                        )
                                ->placeholder('Selecciona el año académico')
                                ->afterStateHydrated(function (Set $set, $record) {
                                        if ($record && $record->careeryear) {
                                            $careeryearname = $record->careeryear->name;
                                            $set('career_year_id', $careeryearname);
                                        }
                                }),
                        // Campo de selección para el grupo
                        Forms\Components\Select::make('group_id')
                                ->relationship('group', 'group_number')
                                ->options(fn (Get $get): Collection => Group::query()
                                            ->where('career_year_id', $get('career_year_id'))
                                            ->pluck('group_number','id')
                                        )
                                ->label('Grupo')
                                ->placeholder('Select a group'),
                ]),
            Section::make('Beca')
                ->schema([
                        // Campo para seleccionar el Campus
                        Forms\Components\Select::make('campus')
                            ->label('Cede')
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
                                    $set('room_id', null);
                                   
                                }
                            )
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->room) {
                                    $buildingCampus = $record->room->wing->building->campus;
                                    $set('campus', $buildingCampus);
                                }
                            })
                            ->placeholder('Seleccione la cede')
                            ->hidden(fn () => auth()->user()->hasRole('Wing_Supervisor')),

                        // Campo para seleccionar el edificio (filtrado por sede)
                        Forms\Components\Select::make('building_id')
                            ->label('Edificio')
                            ->options(fn (Get $get): Collection => Building::query()
                            ->where('campus', $get('campus'))
                            ->pluck('name', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->live() // Reactivo para cambiar las alas disponibles
                            ->required()
                            ->afterStateUpdated(function (Set $set) 
                                { 
                                    $set('wing_id', null);
                                    $set('room_id', null);
                                }
                            )
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->room) {
                                    $buildingName = $record->room->wing->building->name;
                                    $set('building_id', $buildingName);
                                }
                            })
                            ->placeholder('Selecione el edificio')
                            ->hidden(fn () => auth()->user()->hasRole('Wing_Supervisor')),

                        // Campo para seleccionar el ala (filtrado por edificio)
                        Forms\Components\Select::make('wing_id')
                            ->label('Ala')
                            ->options(fn (Get $get): Collection => Wing::query()
                                ->where('building_id', $get('building_id'))
                                ->pluck('name', 'id')
                                )
                            ->searchable()
                            ->preload()
                            ->live() // Reactivo para cambiar los cuartos disponibles
                            ->required()
                            ->afterStateUpdated(fn(Set $set) => $set('room_id', null))
                            ->afterStateHydrated(function (Set $set, $record) {
                                if ($record && $record->room) {
                                    $wingName = $record->room->wing->name;
                                    $set('wing_id', $wingName);
                                }
                            })
                            ->placeholder('Seleccione el ala')
                            ->hidden(fn () => auth()->user()->hasRole('Wing_Supervisor')),
                        // Campo para seleccionar la habitación (filtrado por ala)
                        Forms\Components\Select::make('room_id')
                            ->label('Cuarto')
                            ->relationship(name:'room', titleAttribute:'number')
                            ->options(auth()->user()->hasRole('Wing_Supervisor')?
                                        fn (): Collection => Room::query()
                                            ->where('wing_id', auth()->user()->professor->wingsupervisor->wing->id)
                                            ->where('is_available', true)
                                            ->pluck('number', 'id')
                                        :
                                        fn (Get $get): Collection => Room::query()
                                            ->where('wing_id', $get('wing_id'))
                                            ->where('is_available', true)
                                            ->pluck('number', 'id')
                                
                                )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->columnSpan(auth()->user()->hasRole('Wing_Supervisor')?'full':'')
                            ->placeholder('Selecione el cuarto')
                            
                    
                ])->columns(2),
                Section::make('Información del sistema')
                ->schema([
                        // Campo de selección para el grupo
                        Forms\Components\Select::make('user_id')
                                ->relationship('user', 'email')
                                ->label("Correo del usuario"),
                ])->hidden(fn () => !auth()->user()->hasRole('GM')),           
            

            

        
    
        ]);
}   


    public static function table(Table $table): Table
    {   
        return $table
        ->columns([ 
            TextColumn::make('name')
                    ->label('Nombre completo')
                    ->searchable()
                    ->getStateUsing(fn ($record) => $record->name . ' ' . $record->last_name)
                    ->alignCenter(),
            TextColumn::make('dni')->searchable()
                    ->label('Ci')
                    ->alignCenter(),
            TextColumn::make('scholarship_card')->searchable()
                    ->label('Carnet de estudiante')
                    ->alignCenter(),
            TextColumn::make('group.group_number')
                    ->label('Grupo')
                    ->sortable()
                    ->alignCenter(),
            TextColumn::make('room.wing.building.name')
                    ->label('Edificio')
                    ->searchable()
                    ->alignCenter(),
            TextColumn::make('room.wing.name')
                    ->label('Ala')
                    ->sortable()
                    ->alignCenter(),
            TextColumn::make('room.number')
                    ->label('Cuarto')
                    ->sortable()
                    ->alignCenter(),
            // Mostrar la columna de país solo si estamos en la pestaña de extranjeros
            TextColumn::make('country.name')
                    ->label('País')
                    ->visible(false)
                    ->alignCenter(),
            // Mostrar la columna de municipio solo si estamos en la pestaña de locales
            TextColumn::make('municipality.name')
                    ->label('Municipio')
                    ->visible(false)
                    ->alignCenter()
            
        ])
            ->filters([
                //
                    
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('Ver estudiante')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Editar estudiante')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Eliminar estudiante')
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}

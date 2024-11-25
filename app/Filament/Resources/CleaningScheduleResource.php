<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CleaningScheduleResource\Pages;
use App\Filament\Resources\CleaningScheduleResource\RelationManagers;
use App\Filament\Resources\CleaningScheduleResource\RelationManagers\StudentsRelationManager;
use App\Models\CleaningSchedule;
use App\Models\Student;
use App\Models\WingSupervisor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class CleaningScheduleResource extends Resource
{
    protected static ?string $model = CleaningSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $label = 'Cuartelería';

    protected static ?string $pluralLabel = 'Cuartelerías';

    protected static ?int $navigationSort = 3;

    // public static function canAccess(): bool
    // {
    //     return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Faculty_Dean') || auth()->user()->hasRole('Residence_Manager');
    // }
    public static function canCreate(): bool
    {
        return !auth()->user()->hasRole('Student');
    }
    
    public static function canDelete(Model $record): bool
    {
        return !auth()->user()->hasRole('Student');
    }

    public static function canEdit(Model $record): bool
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
                Forms\Components\DatePicker::make('cleaning_date')
                    ->label('Día de la cuartelería')
                    ->required(),
                    // ->afterStateUpdated(function($record){
                    //     dd($record->students->pivot);
                    // }),
                    Forms\Components\Select::make('student_id')
                        ->label('Estudiantes asignados')
                        ->relationship('students', 'name')
                        ->multiple()
                        ->searchable() // Permite buscar estudiantes
                        //->lazy() // Carga diferida
                        //->getOptionLabelUsing(fn ($value) => Student::find($value)?->name) // Muestra el nombre en la opción seleccionada
                        ->options(function () {
                            return auth()->user()->hasRole('Wing_Supervisor')
                                ? Student::whereHas('room', fn ($query) => $query->where('wing_id', auth()->user()->professor->wingsupervisor->wing->id))
                                    ->pluck('name', 'id')
                                : Student::pluck('name', 'id');
                        })->hiddenOn('edit'), // Solo visible en la creación
                    Forms\Components\Repeater::make('students') // Para edición de comentarios
                        ->relationship('students') // Relación configurada
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nombre del estudiante')
                                ->disabled(), // Solo lectura
                            Forms\Components\Textarea::make('pivot.comment')
                                ->label('Comentario')
                                ->rows(3)
                                ->helperText('Escriba notas relacionadas con el estudiante.')
                                ->visible(auth()->user()->hasRole('Wing_Supervisor')), // Solo para supervisores
                    ])
                    ->columns(2)
                    ->hiddenOn('create')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('cleaning_date')
                ->label('Día de la cuartelería')
                ->sortable()
                ->alignCenter(),
                Tables\Columns\TextColumn::make('students_count')
                ->label('Estudiantes asignados')
                ->counts('students') // Muestra la cantidad de estudiantes asignados
                ->alignCenter(),
                
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('Ver cuartelería')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Editar cuartelería')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Eliminar Cuartelería')
                ->label('')
                ->size('xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    // public static function infolist(Infolist $infolist):Infolist
    // {
    //         return $infolist
    //         ->schema([
                
    //             InfolistItem::make('Fecha de la Limpieza')
    //                 ->value(fn (CleaningSchedule $record) => $record->cleaning_date->format('d/m/Y')),
    //             InfolistItem::make('Estudiantes Asignados')
    //                 ->value(fn (CleaningSchedule $record) => $record->students->map(function ($student) {
    //                     return $student->name . ' - Evaluación: ' . $student->pivot->evaluation;
    //                 })->implode(', ')),
    //         ]);
    // }
    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCleaningSchedules::route('/'),
            'create' => Pages\CreateCleaningSchedule::route('/create'),
            'edit' => Pages\EditCleaningSchedule::route('/{record}/edit'),
        ];
    }
}

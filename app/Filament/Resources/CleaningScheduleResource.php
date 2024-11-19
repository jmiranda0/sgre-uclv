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
                    ->label('Schedules day')
                    ->required(),
                    // ->afterStateUpdated(function($record){
                    //     dd($record->students->pivot);
                    // }),
                    Forms\Components\Select::make('student_id') // Campo de selección múltiple de estudiantes
                    ->label('Assigned Students')
                    ->relationship('students','name')
                    ->preload()
                    ->live()
                    ->multiple() // Permite seleccionar varios estudiantes
                    ->options(auth()->user()->hasRole('Wing_Supervisor')?
                                        function () {
                                            return Student::whereHas('room', fn ($query) => $query->where('wing_id', auth()->user()->professor->wingsupervisors->wing->id))
                                                ->pluck('name', 'id');
                                        }
                                        :
                                        Student::all()->pluck('name', 'id')
                                
                                ) // Cargar todos los estudiantes
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('cleaning_date')
                ->label('Schedules day')
                ->sortable()
                ->alignCenter(),
                Tables\Columns\TextColumn::make('students_count')
                ->label('Students Assigned')
                ->counts('students') // Muestra la cantidad de estudiantes asignados
                ->alignCenter(),
                
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('View sheldules day')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Edit sheldules day')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Delete sheldues day')
                ->label('')
                ->size('xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist):Infolist
    {
            return $infolist
            ->schema([
                TextEntry::make('cleaning_date')
                ->label('Schedules day'),
                Section::make()
                ->schema([
                    RepeatableEntry::make('student')
                        
                ])
            ]);
    }
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

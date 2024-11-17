<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CleaningScheduleResource\Pages;
use App\Filament\Resources\CleaningScheduleResource\RelationManagers;
use App\Models\CleaningSchedule;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class CleaningScheduleResource extends Resource
{
    protected static ?string $model = CleaningSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Faculty_Dean') || auth()->user()->hasRole('Residence_Manager');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('cleaning_date')
                    ->label('Schedules day')
                    ->required(),

                Forms\Components\Select::make('student_id')
                    ->label('Select Students')
                    ->multiple() // Permite seleccionar múltiples estudiantes
                    ->relationship('students', 'name') // Asegúrate de que el modelo tenga la relación
                    ->options(Student::all()->pluck('name', 'id')) // Carga todos los estudiantes
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
            TextColumn::make('students')
                ->label('Students information')
                ->formatStateUsing(function ($record) {
                    // Aquí $record es la instancia de CleaningSchedule
                    $students = $record->students; // Obtén la colección de estudiantes

                    if ($students->isNotEmpty()) {
                        return $students->map(function ($student) {
                            return 'Student: '.$student->name . ' Building: ' . 
                                    $student->room->wing->building->name. ' Wing: '.
                                   $student->room->wing->name . ' Room: ' . 
                                   $student->room->number ;
                        })->implode(' , ');
                    }
                    return 'No students assigned';
                })
                ->alignCenter(), // Muestra los nombres de los estudiantes
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

    public static function getRelations(): array
    {
        return [
            //
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

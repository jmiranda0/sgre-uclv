<?php

namespace App\Filament\Resources\CleaningScheduleResource\RelationManagers;

use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->label('Student')
                    ->relationship('students', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Student Name')
                ->getStateUsing(fn ($record) => $record->name . ' ' . $record->last_name),
                Tables\Columns\TextColumn::make('room.wing.building.name')
                ->label('building'),
                Tables\Columns\TextColumn::make('room.wing.name')
                ->label('Wing'),
                Tables\Columns\TextColumn::make('room.number')
                ->label('Room'),
                Tables\Columns\TextColumn::make('pivot.evaluation')
                ->label('Evaluation')
                ->toggleable(isToggledHiddenByDefault:true),
                Tables\Columns\TextColumn::make('pivot.comments')
                ->label('Comments')
                ->toggleable(isToggledHiddenByDefault:true),
                
            
            ])
            ->filters([
                //
            ])
            ->headerActions([
                
            ])
            ->actions([
                
                
            ])
            ->bulkActions([
    
            ]);
    }
}

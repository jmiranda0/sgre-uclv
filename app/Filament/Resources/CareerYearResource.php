<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerYearResource\Pages;
use App\Filament\Resources\CareerYearResource\RelationManagers;
use App\Models\Career;
use App\Models\CareerYear;
use App\Models\Faculty;
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

class CareerYearResource extends Resource
{
    protected static ?string $model = CareerYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Academic Management';
    
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Academic year')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('year')
                    ->unique()
                    ->required(),
                Forms\Components\Select::make('faculty_id')
                ->label('Faculty')
                ->options(Faculty::all()->pluck('name', 'id')) // Consulta de facultad
                ->searchable()
                ->preload()
                ->live() 
                ->afterStateUpdated(fn(Set $set) => $set('career_id', null))
                ->afterStateHydrated(function (Set $set, $record) {
                    if ($record && $record->career) {
                        $facultyname = $record->career->faculty->name;
                        $set('faculty_id', $facultyname);
                    }
                }),
                Forms\Components\Select::make('career_id')
                    ->preload()
                    ->searchable()
                    ->live()
                    ->options(fn (Get $get): Collection => Career::query()
                                    ->where('faculty_id', $get('faculty_id'))
                                    ->pluck('name','id')
                            ) 
                    ->afterStateHydrated(function (Set $set, $record) {
                        if ($record && $record->career) {
                            $careername = $record->career->name;
                            $set('career_id', $careername);
                        }
                    })
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Academic year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('career.name')
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
                ->tooltip('View Academic year')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Edit Academic year')
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
            'index' => Pages\ListCareerYears::route('/'),
            'create' => Pages\CreateCareerYear::route('/create'),
            'edit' => Pages\EditCareerYear::route('/{record}/edit'),
        ];
    }
}

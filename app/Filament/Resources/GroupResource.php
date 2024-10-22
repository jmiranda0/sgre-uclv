<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Models\Career;
use App\Models\CareerYear;
use App\Models\Group;
use App\Models\faculty;
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

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Academic Management';
    
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('group_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('faculty_id')
                    ->label('Faculty')
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
                    }),
                Forms\Components\Select::make('career_id')
                    ->label('Career')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->options(fn (Get $get): Collection => Career::query()
                                    ->where('faculty_id', $get('faculty_id'))
                                    ->pluck('name','id')
                            )
                    ->afterStateUpdated(fn(Set $set) => $set('career_year_id', null))
                    
                    ->placeholder('Select a career')
                    ->afterStateHydrated(function (Set $set, $record) {
                        if ($record && $record->careeryear) {
                            $careername = $record->careeryear->career->name;
                            $set('career_id', $careername);
                        }
                    }),
                Forms\Components\Select::make('career_year_id')
                    ->required()
                    ->label('Academic Year')
                    ->relationship(name:'careerYear', titleAttribute:'name')
                    ->preload()
                    ->searchable()
                    ->live()
                    ->options(fn (Get $get): Collection => CareerYear::query()
                                    ->where('career_id', $get('career_id'))
                                    ->pluck('name','id')
                            )
                    ->placeholder('Select a academic year')
                    ->afterStateHydrated(function (Set $set, $record) {
                        if ($record && $record->careeryear) {
                            $careeryearname = $record->careeryear->name;
                            $set('career_year_id', $careeryearname);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('careerYear.career.name')
                    ->label('Career')
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
                ->tooltip('View Group')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Edit Group')
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
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}

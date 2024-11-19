<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WingResource\Pages;
use App\Filament\Resources\WingResource\RelationManagers;
use App\Filament\Resources\WingResource\RelationManagers\RoomsRelationManager;
use App\Models\Wing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WingResource extends Resource
{
    protected static ?string $model = Wing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    
    protected static ?string $navigationGroup = 'Building Management';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Residence_Manager');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('building_id')
                    ->relationship('building', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('building.name')
                    ->numeric()
                    ->sortable()
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('rooms_count')
                    ->label('Number of Rooms')
                    ->counts('rooms') // Cuenta las alas relacionadas
                    ->getStateUsing(function ($record) {
                        return $record->rooms_count > 0 ? $record->rooms_count : 'No rooms';
                    })
                    ->alignCenter()
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('View Wing')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Edit Wing')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Delete Wing')
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
            RoomsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWings::route('/'),
            'create' => Pages\CreateWing::route('/create'),
            'edit' => Pages\EditWing::route('/{record}/edit'),
        ];
    }
}

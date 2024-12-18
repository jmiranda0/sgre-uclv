<?php

namespace App\Filament\Resources;

use App\Enums\CampusEnum;
use App\Filament\Resources\BuildingResource\Pages;
use App\Filament\Resources\BuildingResource\RelationManagers;
use App\Filament\Resources\BuildingResource\RelationManagers\WingsRelationManager;
use App\Models\Building;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BuildingResource extends Resource
{
    protected static ?string $model = Building::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $label = 'Edificios';

    protected static ?string $navigationGroup = 'Control de recidencias';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Residence_Manager');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del edificio')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('campus')
                    ->label('Campus')
                    ->placeholder('Selecciona la cede')
                    ->options([
                        'Universitaria' => CampusEnum :: UNI->value,                        
                        'Félix Varela' => CampusEnum :: VAREL->value,                        
                        'Manuel Fajardo' => CampusEnum :: FAJARDO->value,                        
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                     ->label('Edificio')
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('wings_count')
                    ->label('Número de alas')
                    ->counts('wings') // Cuenta las alas relacionadas
                    ->getStateUsing(function ($record) {
                        return $record->wings_count > 0 ? $record->wings_count : 'No wings';
                    })
                    ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->actions([
                
                    Tables\Actions\ViewAction::make()
                        ->tooltip('Ver Edificio')
                        ->label('')
                        ->size('xl'),
                    Tables\Actions\EditAction::make()
                        ->tooltip('Editar Edificio')
                        ->label('')
                        ->size('xl'),
                    Tables\Actions\DeleteAction::make()
                        ->tooltip('Eliminar Edificio')
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
            WingsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBuildings::route('/'),
            'create' => Pages\CreateBuilding::route('/create'),
            'edit' => Pages\EditBuilding::route('/{record}/edit'),
        ];
    }
}

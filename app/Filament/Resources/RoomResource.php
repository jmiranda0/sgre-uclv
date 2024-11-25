<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Filament\Resources\RoomResource\RelationManagers\StudentsRelationManager;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $label = 'Cuartos';

    protected static ?string $navigationGroup = 'Control de recidencias';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Residence_Manager')|| auth()->user()->hasRole('Wing_Supervisor');
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
                Forms\Components\TextInput::make('number')
                    ->label('Número del cuarto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('room_capacity')
                    ->label('Capacidad del cuarto')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_available')
                    ->label('Disponible')
                    ->required(),
                Forms\Components\Select::make('wing_id')
                    ->placeholder('Sleleccione el ala')
                    ->relationship('wing', 'name')
                    ->hidden(fn () => auth()->user()->hasRole('Wing_Supervisor'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wing.building.name')
                    ->hidden(fn () => auth()->user()->hasRole('Wing_Supervisor'))
                    ->label('Edificio')
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('wing.name')
                    ->hidden(fn () => auth()->user()->hasRole('Wing_Supervisor'))
                    ->label('Ala')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('number')
                    ->label('Cuarto')
                    ->searchable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('room_capacity')
                    ->label('Capacidad del cuarto')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('students_count')
                    ->label('Cantidad de estudiantes')
                    ->counts('students')
                    ->getStateUsing(function ($record) {
                        return $record->students_count > 0 ? $record->students_count < $record->room_capacity ? $record->students_count: 'the room is full' : 'No students';
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Disponible')
                    ->boolean()
                    ->alignCenter(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->tooltip('Ver cuarto')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Editar cuarto')
                ->label('')
                ->size('xl'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Eliminar cuarto')
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
            StudentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}

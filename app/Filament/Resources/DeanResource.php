<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeanResource\Pages;
use App\Filament\Resources\DeanResource\RelationManagers;
use App\Models\Dean;
use App\Models\Professor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeanResource extends Resource
{
    protected static ?string $model = Dean::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('professor.name')
                     ->required()
                     ->label('Name'),
                Forms\Components\TextInput::make('professor.dni')
                    ->required(),
                Forms\Components\Select::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->required(),
            ]);
    }
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear el profesor con los datos del formulario
        $professor = Professor::create([
            'name' => $data['professor']['name'],
            'email' => $data['professor']['email'],
        ]);

        // Asignar el professor_id al decano
        $data['professor_id'] = $professor->id;
        dd($data);
        // Retornar los datos modificados para crear el decano
        return $data;
    }
    public static function saved($record)
    {
        // Asigna los roles seleccionados al usuario
        dd($record);
        // $professor = Professor::create([
        //     'name' => $data['professor']['name'],
        //     'email' => $data['professor']['email'],
        // ]);
        
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professor.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('faculty_id')
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
                ->tooltip('View Dean')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Edit Dean')
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
            'index' => Pages\ListDeans::route('/'),
            'create' => Pages\CreateDean::route('/create'),
            'edit' => Pages\EditDean::route('/{record}/edit'),
        ];
    }
}

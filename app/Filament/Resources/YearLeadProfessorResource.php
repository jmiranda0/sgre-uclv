<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YearLeadProfessorResource\Pages;
use App\Filament\Resources\YearLeadProfessorResource\RelationManagers;
use App\Models\Professor;
use App\Models\YearLeadProfessor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YearLeadProfessorResource extends Resource
{
    protected static ?string $model = YearLeadProfessor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        return request()->user()->can('view_year_lead_professors');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('professor_id')
                    ->relationship('professor', 'name')
                    ->required(),
                Forms\Components\TextInput::make('career_year_id')
                    ->required()
                    ->numeric(),
                
            ]);
            // Forms\Components\Section::make('Professor Information')
            //         ->schema([
            //             Forms\Components\TextInput::make('professor.name')
            //                 ->required()
            //                 ->label('Name'),
            //             Forms\Components\TextInput::make('professor.email')
            //                 ->email()
            //                 ->required()
            //                 ->label('Email'),
            //         ]),
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
                Tables\Columns\TextColumn::make('career_year_id')
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
                ->tooltip('View Year Lead Professor')
                ->label('')
                ->size('xl'),
                Tables\Actions\EditAction::make()
                ->tooltip('Edit Year Lead Professor')
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
            'index' => Pages\ListYearLeadProfessors::route('/'),
            'create' => Pages\CreateYearLeadProfessor::route('/create'),
            'edit' => Pages\EditYearLeadProfessor::route('/{record}/edit'),
        ];
    }
}

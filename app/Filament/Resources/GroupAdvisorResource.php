<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupAdvisorResource\Pages;
use App\Filament\Resources\GroupAdvisorResource\RelationManagers;
use App\Models\career;
use App\Models\CareerYear;
use App\Models\Group;
use App\Models\GroupAdvisor;
use App\Models\Municipality;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class GroupAdvisorResource extends Resource
{
    protected static ?string $model = GroupAdvisor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('career_Dean');
    }
    
    public static function canViewAny(): bool
    {
        return request()->user()->can('view_group_supervisors');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('professor.name')
                     ->required()
                     ->label('Name')
                     ->afterStateHydrated(function (Set $set, $record) {
                        if ($record && $record->professor) {
                            $professorname = $record->professor->name;
                            $set('professor.name', $professorname);
                        }
                    }),
                Forms\Components\TextInput::make('professor.dni')
                    ->required()
                    ->afterStateHydrated(function (Set $set, $record) {
                        if ($record && $record->professor) {
                            $professordni = $record->professor->dni;
                            $set('professor.dni', $professordni);
                        }
                    }),
                Forms\Components\Select::make('career_id')
                    ->label('career')
                    ->placeholder('Select a career')
                    ->options(Career::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('career_year_id', null)) 
                    ->afterStateHydrated(function (Set $set, $record) {
                        if ($record && $record->group) {
                            $careername = $record->group->careerYear->career->name;
                            $set('career_id', $careername);
                        }
                    }),
                Forms\Components\Select::make('career_year_id')
                    ->label('academic year')
                    ->options(fn (Get $get): Collection => CareerYear::query()
                                            ->where('career_id', $get('career_id'))
                                            ->pluck('name','id')
                                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->placeholder('Select an acacemic year'),

                Forms\Components\Select::make('group_id')
                    ->relationship(name:'group',titleAttribute:'group_number')
                    ->placeholder('Select a group')
                    ->options(fn (Get $get): Collection => Group::query()
                                            ->where('career_year_id', $get('career_year_id'))
                                            ->pluck('group_number','id')
                                    )
                    ->live()
                    ->preload()
                    ->required(),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('professor.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.group_number')
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
                    ->tooltip('View Group Advisor')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\EditAction::make()
                    ->tooltip('Edit Group Advisor')
                    ->label('')
                    ->size('xl'),
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Delete Group Advisor')
                    ->label('')
                    ->size('xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Information')
                    ->schema([
                        TextEntry::make('professor.name')
                            ->label('Name'),  
                        TextEntry::make('professor.dni')
                            ->label('Dni'), 
                        TextEntry::make('group.careerYear.career.faculty.name')
                            ->label('Faculty'),
                        TextEntry::make('group.careerYear.career.name')
                            ->label('Career'),
                        TextEntry::make('group.group_number')
                            ->label('Group'),
                    ])->columns(2)
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
            'index' => Pages\ListGroupAdvisors::route('/'),
            'create' => Pages\CreateGroupAdvisor::route('/create'),
            'edit' => Pages\EditGroupAdvisor::route('/{record}/edit'),
        ];
    }
}

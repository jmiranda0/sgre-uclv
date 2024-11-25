<?php

namespace App\Filament\Resources;

use App\Enums\ComplaintStatusEnum;
use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Filament\Resources\ComplaintResource\Widgets\ComplaintStats;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Queja/Planteamiento';

    protected static ?string $pluralLabel = 'Quejas/Planteamientos';

    protected static ?int $navigationSort = 2;
    
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('GM') || auth()->user()->hasRole('Residence_Manager') || auth()->user()->hasRole('Student');
    }
    
    public static function canCreate(): bool
    {
        return !auth()->user()->hasRole('Residence_Manager');
    }
    
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        return static::getModel()::query()
            ->visibleForUser($user); // Aplicamos el scope definido
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
                Forms\Components\TextInput::make('theme')
                    ->label('Asunto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('text')
                    ->label('Detalles del asunto')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->hidden(auth()->user()->hasRole('Student'))
                    ->options(array_combine(ComplaintStatusEnum::getValues(), ComplaintStatusEnum::getValues()))
                    ->required(),
                Forms\Components\TextInput::make('student_id')
                    ->hidden(true)
                    ->default(auth()->user()->id)
                    ->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('theme')
                    ->label('Asunto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn ($state) => match ($state->value) {
                        'Pendiente' => 'danger',
                        'Revisado' => 'warning',
                        'Solucionados' => 'success',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state->value)),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nombre del estudiante')
                    ->getStateUsing(fn ($record) => $record->student->name . ' ' . $record->student->last_name)
                    ->sortable()
                    ->hidden(auth()->user()->hasRole('Student')),
                Tables\Columns\TextColumn::make('student.room.wing.building.name')
                    ->label('Edificio')
                    ->sortable()
                    ->hidden(auth()->user()->hasRole('Student')),
                
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options(array_combine(ComplaintStatusEnum::getValues(), ComplaintStatusEnum::getValues())),
            ])
            ->actions([
                
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Ver planteamiento')
                        ->size('xl')
                        ->iconPosition(IconPosition::After->value),
                    Tables\Actions\EditAction::make()
                        ->hidden(auth()->user()->hasRole('Student'))
                        ->label('Editar planteamiento')
                        ->size('xl')
                        ->iconPosition(IconPosition::After),
                    Tables\Actions\DeleteAction::make()
                        ->hidden(auth()->user()->hasRole('Student'))
                        ->label('Eliminar planteamiento')
                        ->size('xl')
                        ->iconPosition(IconPosition::After),
                ]),


                Tables\Actions\ActionGroup::make([  
                    Tables\Actions\Action::make('markReviewed')
                        ->label('Marcar como revisado')
                        ->visible(auth()->user()->hasRole('Residence_Manager'))
                        ->action(fn ($record) => $record->update(['status' => ComplaintStatusEnum::REVIEWED->value]))
                        ->requiresConfirmation()
                        ->color('warning')
                        ->icon('heroicon-o-check'),
                    Tables\Actions\Action::make('markResolved')
                        ->label('Marcar como solucionado')
                        ->visible(auth()->user()->hasRole('Residence_Manager'))
                        ->action(fn ($record) => $record->update(['status' => ComplaintStatusEnum::RESOLVED->value]))
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check'),
                  ])->icon('heroicon-o-check-circle'),
                
                
                
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
            
            Tabs::make('Tabs')
                    ->tabs([    
                        // Aquí defines los detalles de la queja con el esquema que desees
                        Tab::make('Planteamiento')
                            ->schema([
                                TextEntry::make('theme')
                                    ->label('Asunto'),      
                                TextEntry::make('status')
                                    ->label('Estado')
                                    ->formatStateUsing(fn ($state) => ucfirst($state->value))
                                    ->badge()
                                    ->color(fn ($state) => match ($state->value) {
                                        'Pendiente' => 'danger',
                                        'Revisado' => 'warning',
                                        'Solucionados' => 'success',
                                        //'rejected' => 'danger',
                                    }),
                                TextEntry::make('text')
                                    ->label('Detalles del asunto')
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Tab::make('Estudiante')
                            ->schema([
                                TextEntry::make('studentName')
                                    ->label('Nombre del estudiante')
                                    ->getStateUsing(fn ($record) => $record->student->name . ' ' . $record->student->last_name),
                                TextEntry::make('student.dni')
                                    ->label('DNI'),
                                TextEntry::make('student.room.wing.building.name')
                                    ->label('Edificio'),
                                TextEntry::make('student.room.wing.name')
                                    ->label('Ala'),
                                TextEntry::make('student.room.number')
                                    ->label('Cuarto'),
                                
                            ])->columns(2),
                    ])->columnSpanFull() 
                                       
                                      
        ]);
}
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}

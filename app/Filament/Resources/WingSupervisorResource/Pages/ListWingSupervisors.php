<?php

namespace App\Filament\Resources\WingSupervisorResource\Pages;

use App\Filament\Resources\WingSupervisorResource;
use App\Models\Wing;
use App\Models\WingSupervisor;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListWingSupervisors extends ListRecords
{
    protected static string $resource = WingSupervisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        $wingSupervisors = WingSupervisor::orderBy('id', 'asc')
                                ->get();
        if(!$wingSupervisors->isempty()){
            
            return [
                Tab::make('Universitaria')
                    ->query(fn (Builder $query) => $query->whereHas('wing.building', fn ($q) => $q->where('campus', 'Universitaria')))
                    ->label('Universitaria')
                    ->badge(fn () => WingSupervisor::whereHas('wing.building',fn ($q) => $q->where('campus', 'Universitaria'))->count()),
    
                Tab::make('Félix Varela')
                    ->query(fn (Builder $query) => $query->whereHas('wing.building', fn ($q) => $q->where('campus', 'Félix Varela')))
                    ->label('Félix Varela')
                    ->badge(fn () => WingSupervisor::whereHas('wing.building',fn ($q) => $q->where('campus', 'Félix Varela'))->count()),
    
                Tab::make('Manuel Fajardo')
                    ->query(fn (Builder $query) => $query->whereHas('wing.building', fn ($q) => $q->where('campus', 'Manuel Fajardo')))
                    ->label('Manuel Fajardo')
                    ->badge(fn () => WingSupervisor::whereHas('wing.building',fn ($q) => $q->where('campus', 'Manuel Fajardo'))->count()),
                    
            ];
        }
        return [];
    
    }
}

<?php

namespace App\Filament\Resources\BuildingResource\Pages;

use App\Filament\Resources\BuildingResource;
use App\Models\Building;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListBuildings extends ListRecords
{
    protected static string $resource = BuildingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        $tabs = [
            'Univercitary' => Tab::make('Univercitary')
                ->badge(Building::where('campus', 'Universitaria')->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('campus', 'Universitaria');
                }),
            'Felix_Varela' => Tab::make('Félix Varela')
                ->badge(Building::where('campus', 'Félix Varela')->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('campus', 'Félix Varela');
                }),
            'Manuel_Fajardo' => Tab::make('Manuel Fajardo')
                ->badge(Building::where('campus', 'Manuel Fajardo')->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('campus', 'Manuel Fajardo');
                }),
        ];
    
        return $tabs;
    }
}

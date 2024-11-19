<?php

namespace App\Filament\Resources\MunicipalityResource\Pages;

use App\Filament\Resources\MunicipalityResource;
use App\Models\Municipality;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListMunicipalities extends ListRecords
{
    protected static string $resource = MunicipalityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        $municipalitys = Municipality::orderBy('id', 'asc')
            ->get();
        if(!$municipalitys->isempty()){
            foreach ($municipalitys as $municipality) {
                $name = $municipality->province->name;
                $slug = str($name)->slug()->toString();
    
                $tabs[$slug] = Tab::make($name)
                    ->badge(Municipality::where('province_id', $municipality->province->id)->count())
                    ->modifyQueryUsing(function ($query) use ($municipality) {
                        return $query->where('province_id', $municipality->province->id);
                    });
            }
            return $tabs;
        }
        return [];

    }
}

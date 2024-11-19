<?php

namespace App\Filament\Resources\CareerResource\Pages;

use App\Filament\Resources\CareerResource;
use App\Models\Career;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListCareers extends ListRecords
{
    protected static string $resource = CareerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        $careers = Career::orderBy('id', 'asc')
            ->get();
        if(!$careers->isempty() && !auth()->user()->hasRole('Faculty_Dean')){
            foreach ($careers as $career) {
                $name = $career->faculty->name;
                $slug = str($name)->slug()->toString();
    
                $tabs[$slug] = Tab::make($name)
                    ->badge(Career::where('faculty_id', $career->faculty->id)->count())
                    ->modifyQueryUsing(function ($query) use ($career) {
                        return $query->where('faculty_id', $career->faculty->id);
                    });
            }
    
            return $tabs;
        }
            return [];
    }
}

<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Enums\ComplaintStatusEnum;
use App\Filament\Resources\ComplaintResource;
use App\Filament\Resources\ComplaintResource\Widgets\ComplaintStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListComplaints extends ListRecords
{
    protected static string $resource = ComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
{
    if (auth()->user()->hasRole('Student'))
        return [];    


    return [
        ComplaintStats::class,
    ];
}

}

<?php

namespace App\Filament\Resources\GroupAdvisorResource\Pages;

use App\Filament\Resources\GroupAdvisorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupAdvisors extends ListRecords
{
    protected static string $resource = GroupAdvisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

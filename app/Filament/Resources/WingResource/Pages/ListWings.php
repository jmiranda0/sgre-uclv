<?php

namespace App\Filament\Resources\WingResource\Pages;

use App\Filament\Resources\WingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWings extends ListRecords
{
    protected static string $resource = WingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

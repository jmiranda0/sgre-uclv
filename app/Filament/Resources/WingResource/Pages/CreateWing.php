<?php

namespace App\Filament\Resources\WingResource\Pages;

use App\Filament\Resources\WingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWing extends CreateRecord
{
    protected static string $resource = WingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
}

<?php

namespace App\Filament\Resources\DeanResource\Pages;

use App\Filament\Resources\DeanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDean extends EditRecord
{
    protected static string $resource = DeanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

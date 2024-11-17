<?php

namespace App\Filament\Resources\WingSupervisorResource\Pages;

use App\Filament\Resources\WingSupervisorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWingSupervisor extends EditRecord
{
    protected static string $resource = WingSupervisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\GroupAdvisorResource\Pages;

use App\Filament\Resources\GroupAdvisorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupAdvisor extends EditRecord
{
    protected static string $resource = GroupAdvisorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\CleaningScheduleResource\Pages;

use App\Filament\Resources\CleaningScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCleaningSchedule extends EditRecord
{
    protected static string $resource = CleaningScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\CleaningScheduleResource\Pages;

use App\Filament\Resources\CleaningScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCleaningSchedules extends ListRecords
{
    protected static string $resource = CleaningScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

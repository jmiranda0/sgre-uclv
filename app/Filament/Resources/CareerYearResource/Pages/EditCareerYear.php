<?php

namespace App\Filament\Resources\CareerYearResource\Pages;

use App\Filament\Resources\CareerYearResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerYear extends EditRecord
{
    protected static string $resource = CareerYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

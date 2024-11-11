<?php

namespace App\Filament\Resources\YearLeadProfessorResource\Pages;

use App\Filament\Resources\YearLeadProfessorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYearLeadProfessors extends ListRecords
{
    protected static string $resource = YearLeadProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

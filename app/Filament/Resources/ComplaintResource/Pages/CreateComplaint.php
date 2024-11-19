<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComplaint extends CreateRecord
{
    protected static string $resource = ComplaintResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        //para pasar el student_id a; formulario
        if(auth()->user()->hasRole('Student')){
            $data ['student_id'] = auth()->user()->student->id;
        }
        return $data;
    }
}

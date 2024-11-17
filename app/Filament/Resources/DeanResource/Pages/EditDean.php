<?php

namespace App\Filament\Resources\DeanResource\Pages;

use App\Filament\Resources\DeanResource;
use App\Models\Professor;
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
    protected function mutateFormDataBefore(array $data)
    {
        // Crear el profesor con los datos del formulario
        $professor = Professor::find([
            $data['professor']['id'],
           
        ]);
        dd($professor);
        $professor->update($data);
        // Retornar los datos modificados para crear el decano
        
    }
}

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
    function mutateFormDataBeforeSave(array $data): array
    {
    
        // buscar el profesor con el dni del formulario
        $professor = Professor::where('dni',$data['professor']['dni'])->first();
        // actualizar el profesor encontrado con los datos del formulario
        $professor -> update($data['professor']);
        // Asignar el professor_id al yearLeadProfessor
        $data['professor_id'] = $professor->id;
         // Retornar los datos modificados para crear el yearLeadProfessor
        return $data;
    }
}

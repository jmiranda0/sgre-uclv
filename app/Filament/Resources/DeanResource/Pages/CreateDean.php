<?php

namespace App\Filament\Resources\DeanResource\Pages;

use App\Filament\Resources\DeanResource;
use App\Models\Professor;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDean extends CreateRecord
{
    protected static string $resource = DeanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear el profesor con los datos del formulario
        $professor = Professor::create([
            'name' => $data['professor']['name'],
            'dni' => $data['professor']['dni'],
        ]);

        // Asignar el professor_id al decano
        $data['professor_id'] = $professor->id;
        // Retornar los datos modificados para crear el decano
        return $data;
    }
}

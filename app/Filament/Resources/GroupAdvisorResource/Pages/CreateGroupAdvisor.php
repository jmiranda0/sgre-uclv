<?php

namespace App\Filament\Resources\GroupAdvisorResource\Pages;

use App\Filament\Resources\GroupAdvisorResource;
use App\Models\Professor;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGroupAdvisor extends CreateRecord
{
    protected static string $resource = GroupAdvisorResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear el profesor con los datos del formulario
        $professor = Professor::create([
            'name' => $data['professor']['name'],
            'dni' => $data['professor']['dni'],
        ]);

        // Asignar el professor_id al GroupAdvisor
        $data['professor_id'] = $professor->id;
        // Retornar los datos modificados para crear el GroupAdvisor
        return $data;
    }
}

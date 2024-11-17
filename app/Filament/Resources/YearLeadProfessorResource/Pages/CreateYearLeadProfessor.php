<?php

namespace App\Filament\Resources\YearLeadProfessorResource\Pages;

use App\Filament\Resources\YearLeadProfessorResource;
use App\Models\Professor;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateYearLeadProfessor extends CreateRecord
{
    protected static string $resource = YearLeadProfessorResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear el profesor con los datos del formulario
        $professor = Professor::create([
            'name' => $data['professor']['name'],
            'dni' => $data['professor']['dni'],
        ]);

        // Asignar el professor_id al yearLeadProfessor
        $data['professor_id'] = $professor->id;
        // Retornar los datos modificados para crear el yearLeadProfessor
        return $data;
    }
}

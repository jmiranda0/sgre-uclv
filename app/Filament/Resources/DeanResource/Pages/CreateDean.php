<?php

namespace App\Filament\Resources\DeanResource\Pages;

use App\Filament\Resources\DeanResource;
use App\Models\Professor;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CreateDean extends CreateRecord
{
    protected static string $resource = DeanResource::class;




protected function mutateFormDataBeforeCreate(array $data): array
{
    
    if($data['existing_P']){
        return $data;
    }
    // Comprobar si el DNI ya existe
    if (Professor::where('dni', $data['professor']['dni'])->exists()) {
        // Notificar al usuario
        Notification::make()
            ->title('DNI Duplicated')
            ->body('The DNI you entered is already in use. Please change it.')
            ->warning()
            ->persistent()
            ->send();

        // Lanzar una excepción de validación para detener el proceso
        throw ValidationException::withMessages([
            'professor.dni' => 'The DNI already exists. Please enter a unique value.',
        ]);
    }

    // Crear el profesor
    $professor = Professor::create([
        'name' => $data['professor']['name'],
        'dni' => $data['professor']['dni'],
    ]);

    // Asignar el professor_id al decano
    $data['professor_id'] = $professor->id;

    return $data;
}

    

}

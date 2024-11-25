<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        // Verifica si el usuario tiene el rol de Wing_Supervisor
        if ($user->hasRole('Wing_Supervisor')) {
            $professor = $user->professor;
                
            // Asegúrate de que el profesor tenga al menos un WingSupervisor asociado
            if ($professor && $professor->wingSupervisors->isNotEmpty()) {
                // Obtener la primera ala supervisada, o puedes añadir una lógica para seleccionar una ala específica
                $wing = $professor->wingSupervisors->first()->wing;

                if ($wing) {
                    // Asigna automáticamente el wing_id basado en el ala supervisada
                    $data['wing_id'] = $wing->id;
                } else {
                    throw new \Exception('El Wing Supervisor no tiene un ala asignada.');
                }
            } else {
                throw new \Exception('El usuario no está correctamente vinculado como Wing Supervisor o no supervisa ninguna ala.');
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}

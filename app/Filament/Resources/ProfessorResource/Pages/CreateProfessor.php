<?php

namespace App\Filament\Resources\ProfessorResource\Pages;

use App\Filament\Resources\ProfessorResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateProfessor extends CreateRecord
{
    protected static string $resource = ProfessorResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear el user con los datos del formulario
       if(!$data['user']['email'] == null && !$data['user']['password'] == null) 
       {
            $user = User::create([
                'name' => $data['name'],
                'password' => Hash::make($data['user']['password']),
                'email' => $data['user']['email'],
            ]);
            // Asignar el user_id al yearLeaduser
            $data['user_id'] = $user->id;
        }
        // Retornar los datos modificados para crear el professor
        return $data;
    }
}

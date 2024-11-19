<?php

namespace App\Filament\Resources\ProfessorResource\Pages;

use App\Filament\Resources\ProfessorResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;


class EditProfessor extends EditRecord
{
    protected static string $resource = ProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    function mutateFormDataBeforeSave(array $data): array
    {
        // buscar el usuario con el email del formulario
        $user = User::where('email',$data['user']['email'])->first();
        
        // información del usuario
        $userInfo = [
            'name' => $data['name'],
            'password' => Hash::make($data['user']['password']),
            'email' => $data['user']['email'],
        ];
       
        if(!$user == null){
            $user -> update($userInfo);
        }else{
            $user = User::create($userInfo);
        }
        // Asignar el user_id al Professor
        $data['user_id'] = $user->id;
         // Retornar los datos modificados para el Professor
        return $data;
    }
}

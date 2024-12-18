<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; 

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        if(!auth()->user()->hasRole('Wing_Supervisor') && !auth()->user()->hasRole('Faculty_Dean') && !auth()->user()->hasRole('Year_Lead_Professor')){
            $tabs = [
            'local_students' => Tab::make('Estudiantes locales')
                ->badge(Student::where('is_foreign', false)->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_foreign', false); // Filtrar solo estudiantes locales
                }),
            'foreign_students' => Tab::make('Estudiantes extrangeros')
                ->badge(Student::where('is_foreign', true)->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_foreign', true); // Filtrar solo estudiantes extranjeros
                }),
        ];
    
        return $tabs;
        }
        return [];
    }
    public function getCurrentTab(): string
{
    return $this->getQuery()->get('tab', 'local_students'); // 'local_students' como predeterminado
}


}

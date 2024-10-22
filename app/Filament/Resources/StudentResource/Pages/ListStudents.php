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
        $tabs = [
            'local_students' => Tab::make('Local Students')
                ->badge(Student::where('is_foreign', false)->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_foreign', false); // Filtrar solo estudiantes locales
                }),
            'foreign_students' => Tab::make('Foreign Students')
                ->badge(Student::where('is_foreign', true)->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('is_foreign', true); // Filtrar solo estudiantes extranjeros
                }),
        ];
    
        return $tabs;
    }
    public function getCurrentTab(): string
{
    return $this->getQuery()->get('tab', 'local_students'); // 'local_students' como predeterminado
}


}

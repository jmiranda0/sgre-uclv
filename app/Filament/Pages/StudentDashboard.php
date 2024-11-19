<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class StudentDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Student Dashboard';
    protected static string $view = 'filament.pages.student-dashboard';

    // Asegúrate de que el nombre de la ruta sea el correcto
    public static function getSlug(): string
    {
        return 'student-dashboard';
    }

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Student');  // Asegúrate de que solo los estudiantes puedan acceder
    }
}

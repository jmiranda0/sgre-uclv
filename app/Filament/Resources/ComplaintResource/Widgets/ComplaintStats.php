<?php

namespace App\Filament\Resources\ComplaintResource\Widgets;

use App\Enums\ComplaintStatusEnum;
use App\Models\Complaint;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

class ComplaintStats extends BaseWidget
{
    //protected static string $view = 'filament.resources.widgets.complaint-stats';
    protected function getStats(): array
    {
        return [
            Card::make('Total de planteamientos', Complaint::count())
                ->color('primary')
                ->icon('heroicon-o-flag') // Icono de bandera
                ->extraAttributes(['class' => 'bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300']), // Clases de Tailwind para bordes redondeados y efectos
    
            Card::make('Planteamientos pendientes', Complaint::where('status', ComplaintStatusEnum::PENDING->value)->count())
                ->color('warning')
                 
                ->extraAttributes([
                    'class' => 'rounded-lg hover:shadow-xl hover:scale-105 transition-transform duration-300',
                ]), // Clases de Tailwind para bordes redondeados y efectos
    
            Card::make('Planteamientos vistos', Complaint::where('status', ComplaintStatusEnum::REVIEWED->value)->count())
                ->color('success')
                ->icon('heroicon-o-check-circle') // Icono de check
                ->extraAttributes(['class' => 'rounded-lg hover:shadow-xl hover:scale-105 transition-transform duration-300']), // Clases de Tailwind para bordes redondeados y efectos
    
            Card::make('Planteamientos solucionados', Complaint::where('status', ComplaintStatusEnum::RESOLVED->value)->count())
                ->color('secondary')
                ->icon('heroicon-o-chart-pie') // Icono de archivo
                ->extraAttributes(['class' => 'rounded-lg hover:shadow-xl hover:scale-105 transition-transform duration-300']), // Clases de Tailwind para bordes redondeados y efectos
        ];
    }
    

    // public function getData(): array
    // {
    //     // Contamos las quejas por estado
    //     $pending = Complaint::where('status', 'pending')->count();
    //     $reviewed = Complaint::where('status', 'reviewed')->count();
    //     $resolved = Complaint::where('status', 'resolved')->count();

    //     return [
    //         'pending' => $pending,
    //         'reviewed' => $reviewed,
    //         'resolved' => $resolved,
    //     ];
    // }
    // public $pending;
    // public $reviewed;
    // public $resolved;

    // public function mount(): void
    // {
    //     $this->pending = Complaint::where('status', 'pending')->count();
    //     $this->reviewed = Complaint::where('status', 'reviewed')->count();
    //     $this->resolved = Complaint::where('status', 'resolved')->count();
    // }

}

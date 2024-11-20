<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make(
                label:'Students amount',
                value:Student::count()
                
            ),
            
        ];
    }
}

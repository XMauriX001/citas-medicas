<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Paciente;
use App\Models\Cita;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        // Solo el admin podrá ver el dashboard
        return Auth::check() && Auth::user()->role === 'admin';
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total de Pacientes', Paciente::count())
                ->description('Pacientes registrados')
                ->descriptionIcon('heroicon-m-users')
                ->chart([7, 10, 15, 25, 30, 35, 40])
                ->color('success'),

            Stat::make('Citas de Hoy', Cita::whereDate('fecha', Carbon::today())->count())
                ->description('Citas para hoy')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([2, 5, 3, 8, 4, 9, 1])
                ->color('info'),
        ];
    }
}
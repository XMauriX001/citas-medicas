<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Paciente;
use App\Models\Cita;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Tarjeta 1: Cuenta absolutamente todos los pacientes en la base de datos
            Stat::make('Total de Pacientes', Paciente::count())
                ->description('Pacientes registrados en la clínica')
                ->descriptionIcon('heroicon-m-users')
                ->chart([7, 10, 15, 25, 30, 35, 40])
                ->color('success'),

            // Tarjeta 2: Filtra las citas donde la columna 'fecha' sea igual a la fecha de hoy
            Stat::make('Citas de Hoy', Cita::whereDate('fecha', Carbon::today())->count())
                ->description('Citas programadas para el día de hoy')
                ->descriptionIcon('heroicon-m-calendar')
                ->chart([2, 5, 3, 8, 4, 9, 1])
                ->color('info'),
        ];
    }
}
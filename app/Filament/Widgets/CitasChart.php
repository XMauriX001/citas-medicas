<?php

namespace App\Filament\Widgets;
use Filament\Widgets\ChartWidget;
use App\Models\Cita;
use Illuminate\Support\Facades\Auth;

class CitasChart extends ChartWidget
{
    protected ?string $heading = 'Gráfico de Citas Diarias';

    public static function canView(): bool
    {
        // Revisa el inicio de sesión y el rol del usuario para determinar si puede ver el dashboard
        return Auth::check() && Auth::user()->role === 'admin';
    }

    protected function getData(): array
    {
        $citasPorDia = Cita::selectRaw('DATE(fecha) as dia, count(*) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Citas Programadas',
                    'data' => $citasPorDia->pluck('total')->toArray(),
                    'borderColor' => '#3b82f6', 
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)', 
                ],
            ],
            'labels' => $citasPorDia->pluck('dia')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
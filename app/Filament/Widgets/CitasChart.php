<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Cita;

class CitasChart extends ChartWidget
{
    protected ?string $heading = 'Gráfico de Citas Diarias';

    protected function getData(): array
    {
        // Agrupamos las citas por fecha y contamos cuántas hay cada día
        $citasPorDia = Cita::selectRaw('DATE(fecha) as dia, count(*) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Citas Programadas',
                    'data' => $citasPorDia->pluck('total')->toArray(),
                    'borderColor' => '#3b82f6', // Color azul de la línea
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)', // Relleno azul transparente
                ],
            ],
            // Estas son las fechas que aparecen en la parte de abajo del gráfico
            'labels' => $citasPorDia->pluck('dia')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
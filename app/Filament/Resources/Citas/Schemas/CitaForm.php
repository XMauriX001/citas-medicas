<?php

namespace App\Filament\Resources\Citas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use App\Models\Paciente;
use App\Models\User;

class CitaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_paciente')
                    ->label('Paciente')
                    ->options(Paciente::all()->pluck('nombre', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),

                Select::make('id_medico')
                    ->label('Médico')
                    ->options(User::where('role', 'medico')->where('activo', true)->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->preload(),

                DatePicker::make('fecha')
                    ->label('Fecha')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->minDate(now()),

                TimePicker::make('hora_inicio')
                    ->label('Hora de Inicio')
                    ->required()
                    ->seconds(false)
                    ->minutesStep(30),

                TimePicker::make('hora_fin')
                    ->label('Hora de Fin')
                    ->required()
                    ->seconds(false)
                    ->minutesStep(30),

                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmada' => 'Confirmada',
                        'cancelada' => 'Cancelada',
                        'completada' => 'Completada',
                    ])
                    ->default('pendiente')
                    ->required(),
            ]);
    }
}
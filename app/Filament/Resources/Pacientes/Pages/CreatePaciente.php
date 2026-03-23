<?php

namespace App\Filament\Resources\Pacientes\Pages;

use App\Filament\Resources\Pacientes\PacienteResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ExpedienteClinico;

class CreatePaciente extends CreateRecord
{
    protected static string $resource = PacienteResource::class;

    protected function afterCreate(): void
    {
        $expedienteData = $this->form->getState()['expedienteClinico'] ?? [];
        
        if (!empty(array_filter($expedienteData))) {
            ExpedienteClinico::create([
                'id_paciente' => $this->record->id,
                ...$expedienteData
            ]);
        }
    }
}

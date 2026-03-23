<?php

namespace App\Filament\Resources\Pacientes\Pages;

use App\Filament\Resources\Pacientes\PacienteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\ExpedienteClinico;

class EditPaciente extends EditRecord
{
    protected static string $resource = PacienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

     protected function mutateFormDataBeforeFill(array $data): array
    {
        
        if ($this->record->expedienteClinico) {
            $data['expedienteClinico'] = $this->record->expedienteClinico->toArray();
        }
        
        return $data;
    }

    protected function afterSave(): void
    {
        $expedienteData = $this->form->getState()['expedienteClinico'] ?? [];
        
        if (!empty(array_filter($expedienteData))) {
            ExpedienteClinico::updateOrCreate(
                ['id_paciente' => $this->record->id],
                $expedienteData
            );
        }
    }
}

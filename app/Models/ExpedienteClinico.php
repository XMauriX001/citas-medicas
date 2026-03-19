<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;

class ExpedienteClinico extends Model
{
    protected $table = 'expedientes_clinicos';

    protected $fillable = [
        'id_paciente',
        'alergias',
        'antecedentes',
        'medicamentos_actuales',
        'tipo_sangre',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}

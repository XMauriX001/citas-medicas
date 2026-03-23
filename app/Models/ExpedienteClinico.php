<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpedienteClinico extends Model
{
    use HasFactory;
    
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

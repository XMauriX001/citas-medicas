<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'citas';

    protected $fillable = [
        'id_paciente',
        'id_medico',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'id_medico');
    }
}

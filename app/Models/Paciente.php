<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExpedienteClinico;
use App\Models\Cita;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;
    
    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'dui',
        'telefono',
        'email',
    ];

    public function expedienteClinico()
    {
        return $this->hasOne(ExpedienteClinico::class, 'id_paciente');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_paciente');
    }

}

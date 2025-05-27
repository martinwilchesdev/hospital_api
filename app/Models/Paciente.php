<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    // campos que pueden asignarse masivamente
    protected $fillable = [
        'nombre',
        'documento',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'genero'
    ];
}

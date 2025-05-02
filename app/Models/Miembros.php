<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miembros extends Model
{
    use HasFactory;

    protected $fillable = [
        'carnet',
        'sexo',
        'nombres',
        'apellidos',
        'cedula',
        'carrera',
        'turno',
        'area_conocimiento',
        'sede',
        'tipo_miembro',
        'telefono',
    ];

    public function servicios()
    {
        return $this->hasMany(ControlServicios::class, 'miembro_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Miembros;

class ControlServicios extends Model
{
    use HasFactory;

    protected $table = 'control_servicios'; 

    protected $fillable = [
        'miembro_id',
        'sala_atencion',
        'tipo_servicio',
        'computadora_id', 
        'libro_id',       
        'atendido_por',
        'ingreso',
        'numero_locker',
        'fecha_devolucion',
    ];

    /**
     * Relación con la tabla miembros (estudiantes o maestros)
     */
    public function miembro()
    {
        return $this->belongsTo(Miembros::class, 'miembro_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'atendido_por');
    }

    public function libro()
    {
        return $this->belongsTo(Libros::class, 'libro_id');
    }

    public function computadora()
    {
        return $this->belongsTo(Computadoras::class, 'computadora_id');
    }
    
    public function devolucion()
    {
        return $this->hasOne(Devoluciones::class, 'control_servicio_id');
    }
}

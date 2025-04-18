<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoluciones extends Model
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = [
        'control_servicio_id',
        'miembro_id',
        'usuario_atendio',
        'tipo_servicio',
        'observaciones',
        'estado',
        'fecha_devolucion',
        'signatura_topografica',
        'codigo_computadora',
        'cantidad',
    ];

    protected $casts = [
        'fecha_devolucion' => 'datetime',
        'cantidad' => 'integer',
    ];

    /**
     * Relación con la tabla control_servicios (el servicio relacionado con la devolución)
     */
    public function controlServicio()
    {
        return $this->belongsTo(ControlServicios::class, 'control_servicio_id');
    }

    /**
     * Relación con la tabla miembros (usuario que recibe la devolución)
     */
    public function miembro_id()
    {
        return $this->belongsTo(Miembros::class, 'miembro_id');
    }

    /**
     * Relación con la tabla users (usuario que atendió la devolución)
     */
    public function usuarioAtendio()
    {
        return $this->belongsTo(User::class, 'usuario_atendio');
    }

 
}

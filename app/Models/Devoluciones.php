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
    public function control_servicio()
    {
        return $this->belongsTo(ControlServicios::class, 'control_servicio_id');
    }

    // Evento para eliminar el registro relacionado en control_servicios
    protected static function booted()
    {
        static::deleting(function ($devolucion) {
            if ($devolucion->control_servicio) {
                $devolucion->control_servicio->delete();
            }
        });
    }

    /**
     * Relación con la tabla miembros (usuario que recibe la devolución)
     */
    public function miembro()
    {
        return $this->belongsTo(Miembros::class, 'miembro_id');
    }

    /**
     * Relación con la tabla users (usuario que atendió la devolución)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_atendio');
    }

    // Relación con Computadora
    public function computadora()
    {
        return $this->belongsTo(Computadoras::class, 'codigo_computadora', 'codigo_computadora');
    }

    // Relación con Libro
    public function libro()
    {
        return $this->belongsTo(Libros::class, 'signatura_topografica', 'signatura_topografica');
    }
 
}

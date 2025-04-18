<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computadoras extends Model
{
    use HasFactory;

    protected $table = 'computadoras';

    protected $fillable = [
        'marca',
        'categoria',
        'modelo',
        'codigo_computadora',
        'cantidad_disponible'
    ];

    /**
     * Relación con la tabla control_servicios (préstamos de pc como servicio)
     */

    public function prestamospc()
    {
        return $this->hasMany(ControlServicios::class, 'computadora_id', 'codigo_computadora');
    }
}

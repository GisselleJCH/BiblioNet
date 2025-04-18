<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    use HasFactory;

    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'autor',
        'categoria',
        'signatura_topografica',
        'cantidad_disponible'
    ];

    /**
     * Relación con la tabla control_servicios (préstamos de libros como servicio)
     */

     public function prestamos()
     {
         return $this->hasMany(ControlServicios::class, 'libro_id', 'signatura_topografica');
     }
     
}

<?php

namespace App\Imports;

use App\Models\Miembros;
use Maatwebsite\Excel\Concerns\ToModel;

class MiembrosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Miembros([
            'carnet' => $row[0], // Columna 1 del Excel
            'nombres' => $row[1], // Columna 2 del Excel
            'apellidos' => $row[2], // Columna 3 del Excel
            'cedula' => $row[3], // Columna 4 del Excel
            'turno' => $row[4], // Columna 5 del Excel
            'sexo' => $row[5], // Columna 6 del Excel
            'area_conocimiento' => $row[6], // Columna 7 del Excel
            'carrera' => $row[7], // Columna 8 del Excel
            'sede' => $row[8], // Columna 9 del Excel
            'tipo_miembro' => $row[9], // Columna 10 del Excel
            'telefono' => $row[10], // Columna 11 del Excel
        ]);
    }
}

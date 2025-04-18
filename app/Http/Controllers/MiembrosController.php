<?php

namespace App\Http\Controllers;

use App\Models\Miembros;
use Illuminate\Http\Request;

class MiembrosController extends Controller
{
    // Método para buscar miembros por carnet o nombre
    public function buscarMiembro(Request $request)
    {
        $query = $request->get('carnet');
        $miembros = Miembros::where('carnet', 'LIKE', "%$query%")->get();
        return response()->json($miembros);
    }

    // Método para registrar un nuevo miembro
    public function registrarMiembro(Request $request)
    {
        $validatedData = $request->validate([
            'carnet' => 'required|unique:miembros',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'sexo' => 'required|string',
            'cedula' => 'required|string',
            'carrera' => 'required|string',
            'turno' => 'required|string',
            'area_conocimiento' => 'required|string',
            'sede' => 'required|string',
            'tipo_miembro' => 'required|string',    
        ]);

        $miembro = Miembros::create($validatedData);

        return response()->json(['success' => true, 'miembro' => $miembro]);
    }
}
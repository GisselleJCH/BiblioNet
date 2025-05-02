<?php

namespace App\Http\Controllers;

use App\Models\Miembros;
use Illuminate\Http\Request;

class MiembrosController extends Controller
{
    // Método para buscar miembros por carnet
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
            'telefono' => 'nullable|string|max:20',
        ]);

        $miembro = Miembros::create($validatedData);

        return response()->json(['success' => true, 'miembro' => $miembro]);
    }

    public function reportes()
    {
        $miembros = Miembros::all();
        return view('modules.dashboard.reportesingresos', compact('miembros'));
    }

    public function edit($id)
    {
        $miembros = Miembros::findOrFail($id);
        return view('modules.dashboard.editingreso', compact('miembros'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'carnet' => 'required|string|max:10|unique:miembros,carnet,' . $id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'sexo' => 'required|string|max:10',
            'cedula' => 'required|string|max:15',
            'carrera' => 'required|string|max:100',
            'turno' => 'required|string|max:10',
            'area_conocimiento' => 'required|string|max:100',
            'sede' => 'required|string|max:100',
            'tipo_miembro' => 'required|string|max:50',
            'telefono' => 'nullable|string|max:20',
        ]);

        $miembro = Miembros::findOrFail($id);
        $miembro->update($validatedData);

        return redirect()->route('miembros.reportes')->with('success', 'Ingreso actualizado correctamente.');
    }

    public function destroy($id)
    {
        $miembro = Miembros::findOrFail($id);
        $miembro->delete();

        return redirect()->route('miembros.reportes')->with('success', 'Ingreso eliminado correctamente.');
    }

    public function buscarIngreso(Request $request)
    {
        $query = $request->input('query');
        $ingresos = Miembros::where('carnet', 'LIKE', "%{$query}%")->pluck('carnet');

        if ($ingresos->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron ingresos con el carnet proporcionado.',
            ]);
        }

        return response()->json([
            'success' => true,
            'ingresos' => $ingresos,
        ]);
    }
}
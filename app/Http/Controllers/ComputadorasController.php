<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computadoras;

class ComputadorasController extends Controller
{
    public function index()
    {
        $computadoras = Computadoras::all();
        return view('modules.dashboard.computadoras');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'marca' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'codigo_computadora' => 'required|string|unique:computadoras,codigo_computadora|max:255',
            'cantidad_disponible' => 'required|integer|min:1',
        ]);

        try {
            // Crear una nueva computadora
            Computadoras::create($request->all());

            return response()->json(['success' => true, 'message' => 'Computadora registrada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al registrar la computadora.']);
        }
    }

    public function reportes()
    {
        $computadoras = Computadoras::all();
        return view('modules.dashboard.reportescomputadoras', compact('computadoras'));
    }

    public function edit($id)
    {
        $computadora = Computadoras::findOrFail($id);
        return view('modules.dashboard.editcomputadoras', compact('computadora'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'marca' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'codigo_computadora' => 'required|string|unique:computadoras,codigo_computadora,' . $id . '|max:255',
            'cantidad_disponible' => 'required|integer|min:1',
        ]);

        try {
            $computadora = Computadoras::findOrFail($id);

            $computadora->update($request->all());

            return redirect()->route('computadoras.reportes')->with('success', 'Computadora actualizada correctamente.');
        } catch (\Exception $e) {
            // Manejar errores y redirigir con un mensaje de error
            return redirect()->back()->with('error', 'Error al actualizar la computadora: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $computadora = Computadoras::findOrFail($id);
        $computadora->delete();

        return redirect()->route('computadoras.reportes')->with('success', 'Computadora eliminada correctamente.');
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('buscar');

        // Filtrar las computadoras según el término de búsqueda
        $computadoras = Computadoras::when($buscar, function ($query, $buscar) {
            return $query->where('marca', 'like', "%$buscar%")
                        ->orWhere('modelo', 'like', "%$buscar%")
                        ->orWhere('codigo_computadora', 'like', "%$buscar%");
        })->get();

        // Retornar los resultados en formato JSON
        return response()->json($computadoras);
    }

    public function buscarComputadoras(Request $request)
    {
        $query = $request->input('query');

        // Buscar computadoras que coincidan con el query
        $computadoras = Computadoras::where('codigo_computadora', 'LIKE', "%{$query}%")
            ->pluck('codigo_computadora'); 

        return response()->json($computadoras);
    }
}
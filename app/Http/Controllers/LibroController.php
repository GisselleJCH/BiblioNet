<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libros;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libros::all();
        return view('modules.dashboard.libros', compact('libros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'signatura_topografica' => 'required|string|max:50|unique:libros',
            'cantidad_disponible' => 'required|integer|min:1',
        ]);

        Libros::create($request->all());

        return redirect()->route('libros.index')->with('success', 'Libro agregado correctamente.');
    }

    public function reportes()
    {
        $libros = Libros::all();
        return view('modules.dashboard.reporteslibros', compact('libros'));
    }

    public function edit($id)
    {
        $libro = Libros::findOrFail($id);
        return view('modules.dashboard.editlibro', compact('libro'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'signatura_topografica' => 'required|string|max:50|unique:libros,signatura_topografica,' . $id,
            'cantidad_disponible' => 'required|integer|min:1',
        ]);

        $libro = Libros::findOrFail($id);
        $libro->update($request->all());

        return redirect()->route('libros.reportes')->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy($id)
    {
        $libro = Libros::findOrFail($id);
        $libro->delete();

        return redirect()->route('libros.reportes')->with('success', 'Libro eliminado correctamente.');
    }

    public function buscarSignaturas(Request $request)
    {
        $query = $request->input('query');
        $signaturas = Libros::where('signatura_topografica', 'LIKE', "%{$query}%")
            ->pluck('signatura_topografica');

        return response()->json($signaturas);
    }
}
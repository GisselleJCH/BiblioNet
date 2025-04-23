<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlServicios;
use App\Models\Devoluciones;
use App\Models\Miembros;
use App\Models\User;
use App\Models\Libros;
use App\Models\Computadoras;
use Illuminate\Support\Facades\Log;

class DevolucionesController extends Controller
{
    /**
     * Mostrar la vista principal de devoluciones.
     */
    public function index()
    {
        $miembros = Miembros::all();
        $usuarios = User::all();

        return view('modules.dashboard.devoluciones', compact('miembros', 'usuarios'));
    }

    /**
     * Obtener préstamos activos de un miembro según el tipo de servicio.
     */
    public function obtenerPrestamos(Request $request)
    {
        $request->validate([
            'carnet' => 'required|exists:miembros,carnet',
            'tipo_servicio' => 'required|string',
        ]);

        $miembro = Miembros::where('carnet', $request->carnet)->firstOrFail();

        $prestamos = ControlServicios::with(['libro', 'computadora'])
            ->where('miembro_id', $miembro->id)
            ->where('tipo_servicio', $request->tipo_servicio)
            ->whereNull('fecha_devolucion')
            ->get();

        if ($prestamos->isEmpty()) {
            return response()->json(['message' => 'No se encontraron préstamos activos'], 404);
        }

        return response()->json($prestamos);
    }

    /**
     * Registrar una devolución y actualizar los estados de los recursos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'control_servicio_id' => 'required|exists:control_servicios,id',
            'estado' => 'required|in:devuelto,extraviado,dañado',
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Obtener el registro de control_servicios relacionado
        $controlServicio = ControlServicios::with(['libro', 'computadora'])->findOrFail($request->control_servicio_id);

        // Crear la devolución
        $devolucion = Devoluciones::create([
            'control_servicio_id' => $controlServicio->id,
            'miembro_id' => $controlServicio->miembro_id,
            'usuario_atendio' => auth()->id(),
            'fecha_devolucion' => now(),
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
            'tipo_servicio' => $controlServicio->tipo_servicio,
            'signatura_topografica' => $controlServicio->libro ? $controlServicio->libro->signatura_topografica : null,
            'codigo_computadora' => $controlServicio->computadora ? $controlServicio->computadora->codigo_computadora : null,
            'cantidad' => $request->cantidad,
        ]);

        // Actualizar el estado del recurso según el tipo de servicio
        if ($request->estado === 'devuelto') {
            if ($controlServicio->libro) {
                // Incrementar la cantidad disponible del libro
                $controlServicio->libro->increment('cantidad_disponible');
            } else {
                Log::warning('El libro asociado al servicio no existe. ID del servicio: ' . $controlServicio->id);
            }

            if ($controlServicio->computadora) {
                // Marcar la computadora como disponible
                $controlServicio->computadora->increment('cantidad_disponible');
            } else {
                Log::warning('La computadora asociada al servicio no existe. ID del servicio: ' . $controlServicio->id);
            }
        }

        // Actualizar la fecha de devolución en el registro de control_servicios
        $controlServicio->update(['fecha_devolucion' => now()]);

        return redirect()->route('devoluciones.index')->with('success', 'Devolución registrada correctamente.');
    }

    //reportes
    public function reportes()
    {
        // Carga las devoluciones con las relaciones necesarias
        $devoluciones = Devoluciones::with(['miembro', 'control_servicio', 'user'])->get();

        // Retorna la vista con los datos
        return view('modules.dashboard.reportesdevoluciones', compact('devoluciones'));
    }

    public function editdevoluciones($id)
    {
        $devolucion = Devoluciones::findOrFail($id);
        $controlServicios = ControlServicios::with(['miembro', 'user'])->get();

        return view('modules.dashboard.editdevoluciones', compact('devolucion', 'controlServicios'));
    }

    public function updatedevoluciones(Request $request, $id)
    {
        $validatedData = $request->validate([
            'miembro_id' => 'required|exists:miembros,id',
            'fecha_devolucion' => 'nullable|date',
            'usuario_atendio' => 'required|exists:users,id',
            'control_servicio_id' => 'required|exists:control_servicios,id',
            'signatura_topografica' => 'nullable|string|max:255',
            'codigo_computadora' => 'nullable|string|max:255',
            'cantidad' => 'required|integer|min:1',
            'estado' => 'required|in:devuelto,extraviado,dañado',
            'observaciones' => 'nullable|string|max:255',
            'tipo_servicio' => 'required|string',
        ]);

        $devoluciones = Devoluciones::findOrFail($id);
        $devoluciones->update($validatedData);

        return redirect()->route('reportes.devoluciones')->with('success', 'Devoluciones actualizada correctamente.');
    }

    public function destroy($id)
    {
        $devolucion = Devoluciones::findOrFail($id);
    
        // Elimina el registro relacionado en control_servicios
        if ($devolucion->control_servicio) {
            $devolucion->control_servicio->delete();
        }
    
        // Elimina la devolución
        $devolucion->delete();
    
        return redirect()->route('reportes.devoluciones')->with('success', 'Devolución y su control de servicio eliminados correctamente.');
    }

    public function buscarDevoluciones(Request $request)
    {
        $query = $request->input('query');
        $devoluciones = Devoluciones::where('carnet', 'LIKE', "%{$query}%")->pluck('carnet');

        if ($devoluciones->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron devoluciones con el carnet proporcionado.',
            ]);
        }

        return response()->json([
            'success' => true,
            'devoluciones' => $devoluciones,
        ]);
    }
}
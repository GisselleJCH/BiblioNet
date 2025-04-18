<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Miembros;
use App\Models\ControlServicios;
use App\Models\Computadoras;
use App\Models\Libros;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ServiciosController extends Controller
{
    public function index()
    {
        $controlServicios = ControlServicios::all();
        $usuarios = User::all();
        return view('modules.dashboard.controlservicios', compact('usuarios'));
    }

    public function services(Request $request)
    {
        // Asignar el usuario autenticado al campo usuario_atendio
        $request->merge(['usuario_atendio' => auth()->id()]);
        
        // Validar los datos de entrada
        $request->validate([
            'miembro_id' => 'required|exists:miembros,id',
            'sala_atencion' => 'required|string|max:255',
            'tipo_servicio' => 'required|string|max:255',
            'computadora_id' => 'nullable|exists:computadoras,id', 
            'libro_id' => 'nullable|exists:libros,id',
            'ingreso' => 'nullable|date',
            'numero_locker' => 'nullable|string|max:255',
            'cantidad' => 'integer|min:1',
        ]);

        // Registrar miembro si no existe
        if (!$request->miembro_id) {
            $miembro = Miembros::create($request->only([
                'carnet', 'sexo', 'nombres', 'apellidos', 'cedula', 'carrera', 'turno', 'area_conocimiento', 'sede', 'tipo_miembro'
            ]));
            $request->merge(['miembro_id' => $miembro->id]);
        } 

        try {
            // Verificar si es un préstamo de computadora
            if ($request->tipo_servicio === 'Préstamo de Computadora') {
                $computadora = Computadoras::where('codigo_computadora', $request->codigo_computadora)->first();
                if (!$computadora) {
                    return redirect()->back()->withErrors(['error' => 'El código de computadora no es válido.']);
                }

                // Verificar si la computadora ya está en uso
                $computadoraEnUso = ControlServicios::where('computadora_id', $computadora->id)
                    ->whereNull('fecha_devolucion') // Asegurarse de que no haya sido devuelta
                    ->exists();

                if ($computadoraEnUso) {
                    return redirect()->back()->withErrors(['error' => 'La computadora seleccionada ya está en uso.']);
                }

                // Restar la cantidad disponible de la computadora
                $computadora->decrement('cantidad_disponible', 1);

                $request->merge(['computadora_id' => $computadora->id]); // Asignar el ID de la computadora
            }
    
            // Verificar si es un préstamo de libro
            if (in_array($request->tipo_servicio, ['Lectura de Material Bibliográfico en Físico', 'Préstamo de Material Bibliográfico a domicilio'])) {
                $libro = Libros::where('signatura_topografica', $request->signatura_topografica)->first();
                if (!$libro) {
                    return redirect()->back()->withErrors(['error' => 'La signatura topográfica no es válida.']);
                }

                // Verificar si hay suficientes libros disponibles
                if ($libro->cantidad_disponible < $request->cantidad) {
                    return redirect()->back()->withErrors(['error' => 'No hay suficientes libros disponibles para este préstamo.']);
                }

                // Restar la cantidad prestada
                $libro->decrement('cantidad_disponible', $request->cantidad);

                $request->merge(['libro_id' => $libro->id]); // Asignar el ID del libro
            }
    
            // Guardar el registro en la tabla control_servicios
            $controlServicio = ControlServicios::create([
                'miembro_id' => $request->miembro_id,
                'sala_atencion' => $request->sala_atencion,
                'tipo_servicio' => $request->tipo_servicio,
                'computadora_id' => $request->computadora_id, 
                'libro_id' => $request->libro_id,            
                'atendido_por' => $request->usuario_atendio,
                'ingreso' => $request->ingreso ?? now(),
                'numero_locker' => $request->numero_locker,
                'fecha_devolucion' => null, 
            ]);

            return redirect()->back()->with('success', 'Servicio registrado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al registrar el servicio: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al registrar el servicio.']);
        }
    }

    public function getUsuario($carnet)
    {
        $miembros = Miembros::where('carnet', 'like', "%$carnet%")->get();
        return response()->json($miembros);
    }

    public function obtenerTipoPrestamo($id)
    {
        $servicio = ControlServicios::find($id);

        if ($servicio) {
            $tipoPrestamo = $servicio->tipo_servicio;
            return response()->json(['success' => true, 'tipo_prestamo' => $tipoPrestamo]);
        }

        return response()->json(['success' => false, 'message' => 'Servicio no encontrado']);
    }
}
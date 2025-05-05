<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReportesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{
    public function index()
    {
        return view('modules.dashboard.reportesbiblioteca');
    }

    // Exportar tabla a Excel
    public function exportarTablaExcel(Request $request)
    {
        $reportes = $this->obtenerDatos($request, false);
        return Excel::download(new ReportesExport($reportes, 'tabla'), 'tabla_reportes_biblioteca.xlsx');
    }

    // Exportar gráficos a Excel
    public function exportarGraficosExcel(Request $request)
    {
        $reportes = $this->obtenerDatos($request, false);

        // Generar las rutas de las imágenes guardadas
        $imagenes = [
            'graficoSexo' => public_path('storage/graficos/grafico-sexo.png'),
            'graficoTipoServicio' => public_path('storage/graficos/grafico-tipo-servicio.png'),
            'graficoAreaConocimiento' => public_path('storage/graficos/grafico-area-conocimiento.png'),
            'graficoSalaAtencion' => public_path('storage/graficos/grafico-sala-atencion.png'),
            'graficoCarrera' => public_path('storage/graficos/grafico-carrera.png'),
            'graficoTurno' => public_path('storage/graficos/grafico-turno.png'),
            'graficoSede' => public_path('storage/graficos/grafico-sede.png'),
        ];

        foreach ($imagenes as $key => $path) {
            if (!file_exists($path)) {
                return redirect()->back()->with('error', "La imagen {$key} no existe en la ruta {$path}");
            }
        }

        return Excel::download(new ReportesExport([], 'graficos', $imagenes), 'graficos_reportes_biblioteca.xlsx');
    }

    // Exportar tabla a PDF
    public function exportarTablaPDF(Request $request)
    {
        $reportes = $this->obtenerDatos($request, false);

        $pdf = Pdf::loadView('modules.dashboard.reportes-tabla-pdf', [
            'reportes' => $reportes,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('tabla_reportes_biblioteca.pdf');
    }

    // Exportar gráficos a PDF
    public function exportarGraficosPDF(Request $request)
    {
        // Obtener los datos de los gráficos filtrados por fechas
        $graficos = $this->generarGraficos($request)->getData(true);

        // Generar las rutas de las imágenes guardadas
        $imagenes = [
            'graficoSexo' => public_path('storage/graficos/grafico-sexo.png'),
            'graficoTipoServicio' => public_path('storage/graficos/grafico-tipo-servicio.png'),
            'graficoAreaConocimiento' => public_path('storage/graficos/grafico-area-conocimiento.png'),
            'graficoSalaAtencion' => public_path('storage/graficos/grafico-sala-atencion.png'),
            'graficoCarrera' => public_path('storage/graficos/grafico-carrera.png'),
            'graficoTurno' => public_path('storage/graficos/grafico-turno.png'),
            'graficoSede' => public_path('storage/graficos/grafico-sede.png'),
        ];

        // Generar el PDF con los datos de los gráficos y las imágenes
        $pdf = Pdf::loadView('modules.dashboard.reportes-graficos-pdf', [
            'totales' => $graficos['totales'],
            'imagenes' => $imagenes,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('graficos_reportes_biblioteca.pdf');
    }

    // Método para obtener los datos de la tabla
    public function obtenerDatos(Request $request, $returnJson = true)
    {
        $query = DB::table('control_servicios')
            ->leftJoin('miembros', 'control_servicios.miembro_id', '=', 'miembros.id') // Cambiado a LEFT JOIN
            ->leftJoin('devoluciones', 'control_servicios.id', '=', 'devoluciones.control_servicio_id') // Cambiado a LEFT JOIN
            ->leftJoin('users', 'control_servicios.atendido_por', '=', 'users.id') // Cambiado a LEFT JOIN
            ->select(
                'control_servicios.*',
                'miembros.carnet',
                'miembros.nombres',
                'miembros.apellidos',
                'miembros.cedula',
                'miembros.turno',
                'miembros.sexo',
                'miembros.area_conocimiento',
                'miembros.carrera',
                'miembros.sede',
                'miembros.tipo_miembro',
                'miembros.telefono',
                DB::raw("
                    CASE 
                        WHEN control_servicios.tipo_servicio IN ('Lectura de Material Bibliográfico en Físico', 'Préstamo de Material Bibliográfico a domicilio') 
                        THEN devoluciones.signatura_topografica
                        ELSE NULL
                    END as signatura_topografica
                "),
                'devoluciones.codigo_computadora as codigo_computadora',
                'devoluciones.cantidad',
                'users.name as atendido_por'
            );

        // Filtrar por rango de fechas
        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $query->whereBetween('control_servicios.ingreso', [$request->fecha_desde, $request->fecha_hasta]);
        }

        // Filtrar por tipo y categoría
        if ($request->filled('tipo') && $request->tipo !== 'todo') {
            $tipo = $request->tipo;

            if ($request->filled('categoria') && $request->categoria !== 'todo') {
                $categoria = $request->categoria;
                $query->where($tipo, $categoria);
            } else {
                $query->whereNotNull($tipo); // Si no hay categoría, filtrar solo por tipo
            }
        }

        $reportes = $query->get();

        // Si no hay datos, devolver un array vacío para evitar errores en los gráficos
        if ($reportes->isEmpty()) {
            Log::info('No se encontraron datos para los filtros aplicados.');
        }

        return $returnJson ? response()->json($reportes) : $reportes;
    }

    // Método para generar los datos de los gráficos
    public function generarGraficos(Request $request)
    {
        // Obtener los datos filtrados por fecha desde la tabla control_servicios
        $reportes = $this->obtenerDatos($request, false);

        // Totales basados en los reportes filtrados
        $totales = [
            'estudiantes' => $reportes->where('tipo_miembro', 'Estudiante')->unique('miembro_id')->count(), // Estudiantes únicos
            'docentes' => $reportes->where('tipo_miembro', 'Docente')->unique('miembro_id')->count(),       // Maestros únicos
            'servicios' => $reportes->count(),  // Total de servicios registrados
        ];

        // Datos para los gráficos
        $graficos = [
            'area_conocimiento' => [
                'labels' => $reportes->groupBy('area_conocimiento')->keys()->toArray(),
                'data' => $reportes->groupBy('area_conocimiento')->map->count()->values()->toArray(),
            ],
            'sexo' => [
                'labels' => ['Femenino', 'Masculino'],
                'data' => [
                    $reportes->where('sexo', 'Femenino')->count(),
                    $reportes->where('sexo', 'Masculino')->count(),
                ],
            ],
            'tipo_servicio' => [
                'labels' => $reportes->groupBy('tipo_servicio')->keys()->toArray(),
                'data' => $reportes->groupBy('tipo_servicio')->map->count()->values()->toArray(),
            ],
            'sala_atencion' => [
                'labels' => $reportes->groupBy('sala_atencion')->keys()->toArray(),
                'data' => $reportes->groupBy('sala_atencion')->map->count()->values()->toArray(),
            ],
            'carrera' => [
                'labels' => $reportes->groupBy('carrera')->keys()->toArray(),
                'data' => $reportes->groupBy('carrera')->map->count()->values()->toArray(),
            ],
            'turno' => [
                'labels' => $reportes->groupBy('turno')->keys()->toArray(),
                'data' => $reportes->groupBy('turno')->map->count()->values()->toArray(),
            ],
            'sede' => [
                'labels' => $reportes->groupBy('sede')->keys()->toArray(),
                'data' => $reportes->groupBy('sede')->map->count()->values()->toArray(),
            ],
        ];

        // Retornar los datos en formato JSON
        return response()->json([
            'totales' => $totales,
            'area_conocimiento' => $graficos['area_conocimiento'],
            'sexo' => $graficos['sexo'],
            'tipo_servicio' => $graficos['tipo_servicio'],
            'sala_atencion' => $graficos['sala_atencion'],
            'carrera' => $graficos['carrera'],
            'turno' => $graficos['turno'],
            'sede' => $graficos['sede'],
        ]);
    }

    public function guardarGrafico(Request $request)
    {
        try {
            $imagenes = $request->input('imagenes');

            if (!$imagenes || !is_array($imagenes)) {
                throw new \Exception("El campo 'imagenes' es requerido y debe ser un array.");
            }

            foreach ($imagenes as $nombre => $base64) {
                if (preg_match('#^data:image/\w+;base64,#i', $base64)) {
                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
                    $path = public_path("storage/graficos/{$nombre}.png");
                    file_put_contents($path, $data);
                } else {
                    throw new \Exception("El formato de la imagen '{$nombre}' no es válido.");
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error al guardar gráficos: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


    public function obtenerOpcionesPorTipo(Request $request)
    {
        $tipo = $request->input('tipo');
        $tiposPermitidos = ['signatura_topografica', 'codigo_computadora', 'name', 'carnet'];

        if (!in_array($tipo, $tiposPermitidos)) {
            return response()->json(['error' => 'Tipo no válido'], 400);
        }

        $opciones = match ($tipo) {
            'signatura_topografica' => DB::table('libros')->pluck('signatura_topografica'),
            'codigo_computadora' => DB::table('computadoras')->pluck('codigo_computadora'),
            'name' => DB::table('users')->pluck('name'),
            'carnet' => DB::table('miembros')->pluck('carnet'),
            default => [],
        };

        return response()->json($opciones);
    }

}
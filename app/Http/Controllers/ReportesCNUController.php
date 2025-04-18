<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportesExport; 

class ReportesCNUController extends Controller
{
    public function index()
    {
        return view('modules.dashboard.reportescnu');
    }
    
    public function obtenerDatos(Request $request, $returnJson = true)
    {
        $query = DB::table('control_servicios')
            ->leftJoin('miembros', 'control_servicios.miembro_id', '=', 'miembros.id') // Cambiado a LEFT JOIN
            ->leftJoin('devoluciones', 'control_servicios.id', '=', 'devoluciones.control_servicio_id') // Cambiado a LEFT JOIN
            ->leftJoin('users', 'control_servicios.atendido_por', '=', 'users.id') // Cambiado a LEFT JOIN
            ->select(
                'control_servicios.*', // Seleccionar todas las columnas de control_servicios
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

        $reportes = $query->get();

        if ($returnJson) {
            return response()->json($reportes);
        }

        // De lo contrario, devolver la colección directamente
        return $reportes;
    }
    
    public function exportarPDF(Request $request)
    {
        $reportes = $this->obtenerDatos($request, false); 
    
        $pdf = Pdf::loadView('modules.dashboard.reportes-pdf', ['reportes' => $reportes->toArray()])
                  ->setPaper('a4', 'landscape');
    
        return $pdf->download('reportes-cnu.pdf');
    }

    public function exportarExcel(Request $request)
    {
        $reportes = $this->obtenerDatos($request, false);

        return Excel::download(new ReportesExport($reportes, 'tabla'), 'tabla_reportes_cnu.xlsx');
    }
}

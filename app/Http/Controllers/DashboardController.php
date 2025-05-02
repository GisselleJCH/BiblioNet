<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libros;
use App\Models\ControlServicios;
use App\Models\Devoluciones;
use App\Models\Miembros;

class DashboardController extends Controller
{
    public function index()
    {
        // Contar libros disponibles
        $librosRegistrados = Libros::where('cantidad_disponible', '>', 0)->count();

        // Contar préstamos de libros
        $prestamosLibros = ControlServicios::whereIn('tipo_servicio', [
            'Préstamo de Material Bibliográfico a domicilio',
            'Lectura de Material Bibliográfico en Físico'
        ])->count();

        // Contar devoluciones de libros
        $devolucionesLibros = Devoluciones::whereIn('tipo_servicio', [
            'Préstamo de Material Bibliográfico a domicilio',
            'Lectura de Material Bibliográfico en Físico'
        ])->count();

        // Contar estudiantes registrados
        $estudiantesRegistrados = Miembros::where('tipo_miembro', 'Estudiante')->count();

        // Contar préstamos de PC
        $prestamosPC = ControlServicios::where('tipo_servicio', 'Préstamo de Computadora')->count();

        // Contar préstamos de auditorio
        $prestamosAuditorio = ControlServicios::where('tipo_servicio', 'Capacitación a Usuarios')->count();

        // Pasar datos a la vista
        return view('modules.dashboard.home', compact(
            'librosRegistrados',
            'prestamosLibros',
            'devolucionesLibros',
            'estudiantesRegistrados',
            'prestamosPC',
            'prestamosAuditorio'
        ));
    }

    public function ayuda()
    {
        return view('modules.dashboard.ayuda');
    }

    public function politicas()
    {
        return view('modules.dashboard.politicas');
    }
    public function terminos()
    {
        return view('modules.dashboard.terminos');
    }
}

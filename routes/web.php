<?php
// Ensure this is the only PHP opening tag and no HTML or other content is interfering.

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerfilController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\MiembrosController;
use App\Http\Controllers\DevolucionesController;
use App\Http\Controllers\ComputadorasController;
use App\Http\Controllers\ReportesCNUController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. 
|
*/

//manda a llamar las rutas que definamos
Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/registro', [AuthController::class, 'registro'])->name('registro');
    Route::post('/registrar', [AuthController::class, 'registrar'])->name('registrar');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/perfil/edit', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::post('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/ayuda', [DashboardController::class, 'ayuda'])->name('ayuda');
    Route::get('/politicas', [DashboardController::class, 'politicas'])->name('politicas');
    Route::get('/terminos', [DashboardController::class, 'terminos'])->name('terminos');


    // Rutas para miembros / user
    Route::get('/buscar-miembro', [MiembrosController::class, 'buscarMiembro'])->name('miembros.buscarMiembro');
    Route::post('/registrar-miembro', [MiembrosController::class, 'registrarMiembro'])->name('miembros.registrarMiembro');
    Route::get('/miembros/reportes', [MiembrosController::class, 'reportes'])->name('miembros.reportes');
    Route::get('/buscar', [MiembrosController::class, 'buscarIngreso'])->name('miembros.buscar');
    Route::get('/{id}/editar', [MiembrosController::class, 'edit'])->name('miembros.editar');
    Route::put('/{id}', [MiembrosController::class, 'update'])->name('miembros.actualizar');
    Route::delete('/{id}', [MiembrosController::class, 'destroy'])->name('miembros.eliminar');
    Route::get('/usuarios/listado', [UserController::class, 'listado']);
    Route::post('/miembros/importar', [MiembrosController::class, 'importar'])->name('miembros.importar');
    Route::get('/importaciondatos', [MiembrosController::class, 'importaciondatos'])->name('importaciondatos');
    
    // Rutas para libros
    Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
    Route::post('/libros', [LibroController::class, 'store'])->name('libros.store');
    Route::resource('libros', LibroController::class);
    Route::get('reporteslibros', [LibroController::class, 'reportes'])->name('libros.reportes');
    Route::get('/buscar-signaturas', [LibroController::class, 'buscarSignaturas']);

    // Rutas para devoluciones
    Route::get('/devoluciones', [DevolucionesController::class, 'index'])->name('devoluciones.index');
    Route::post('/registrar-devolucion', [DevolucionesController::class, 'store'])->name('devoluciones.store');
    Route::post('/prestamos/obtener', [DevolucionesController::class, 'obtenerPrestamos'])->name('prestamos.obtener');
    Route::get('/reportesdevoluciones', [DevolucionesController::class, 'reportes'])->name('reportes.devoluciones');
    Route::get('/editardevoluciones/{id}', [DevolucionesController::class, 'editdevoluciones'])->name('devoluciones.editar');
    Route::put('/actualizardevoluciones/{id}', [DevolucionesController::class, 'updatedevoluciones'])->name('devoluciones.actualizar');
    Route::delete('/eliminardevoluciones/{id}', [DevolucionesController::class, 'destroy'])->name('devoluciones.eliminar');
    Route::get('/buscardevoluciones', [DevolucionesController::class, 'buscarDevoluciones'])->name('devoluciones.buscar');

    // Rutas para control de servicios
    Route::post('control-servicios', [ServiciosController::class, 'services'])->name('servicios.services');
    Route::get('control-servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/tipo/{id}', [ServiciosController::class, 'obtenerTipoPrestamo'])->name('servicios.tipo');
    Route::get('/reportesservicios', [ServiciosController::class, 'reportes'])->name('servicios.reportes');
    Route::get('/editar/{id}', [ServiciosController::class, 'edit'])->name('servicios.editar');
    Route::put('/actualizar/{id}', [ServiciosController::class, 'update'])->name('servicios.actualizar');
    Route::delete('/eliminar/{id}', [ServiciosController::class, 'destroy'])->name('servicios.eliminar');
    Route::get('/buscar', [ServiciosController::class, 'buscarServicio'])->name('servicios.buscar');
    Route::get('/reportes-biblioteca/opciones', [ReporteController::class, 'obtenerOpcionesPorTipo']);

    // Rutas para computadoras
    Route::get('/buscar-computadoras', [ComputadorasController::class, 'buscarComputadoras']);
    Route::get('/computadoras/buscar', [ComputadorasController::class, 'buscar'])->name('computadoras.buscar');
    Route::get('/computadoras/codigos', [ComputadorasController::class, 'obtenerCodigosComputadora'])->name('computadoras.codigos');
    Route::get('/computadoras', [ComputadorasController::class, 'index'])->name('computadoras.index');
    Route::get('reportescomputadoras', [ComputadorasController::class, 'reportes'])->name('computadoras.reportes');
    Route::post('/computadora', [ComputadorasController::class, 'store'])->name('computadoras.store');
    Route::get('/buscar-computadoras', [ComputadorasController::class, 'buscarComputadoras']);
    Route::get('/computadoras/{id}/edit', [ComputadorasController::class, 'edit'])->name('computadoras.edit');
    Route::put('/computadoras/{id}', [ComputadorasController::class, 'update'])->name('computadoras.update');
    Route::delete('/computadoras/{id}', [ComputadorasController::class, 'destroy'])->name('computadoras.destroy');

    // Rutas para reportes cnu
    Route::get('/reportes-cnu', [ReportesCNUController::class, 'index'])->name('reportes.cnu');
    Route::get('/reportes-cnu/buscar', [ReportesCNUController::class, 'obtenerDatos'])->name('reportes.cnu.buscar');
    Route::get('/reportes-cnu/exportar-pdf', [ReportesCNUController::class, 'exportarPDF'])->name('reportes.cnu.exportar.pdf');
    Route::get('/reportes-cnu/exportar-excel', [ReportesCNUController::class, 'exportarExcel'])->name('reportes.cnu.exportar.excel');
    
    // Rutas para reportes de biblioteca
    Route::get('/reportes-biblioteca', [ReporteController::class, 'index'])->name('reportes.biblioteca');
    Route::get('/reportes-biblioteca/buscar', [ReporteController::class, 'obtenerDatos'])->name('reportes.biblioteca.buscar');
    Route::get('/reportes-biblioteca/graficos', [ReporteController::class, 'generarGraficos'])->name('reportes.biblioteca.graficos');
    // Exportar tabla
    Route::get('/reportes-biblioteca/exportar-tabla-pdf', [ReporteController::class, 'exportarTablaPDF'])->name('reportes.biblioteca.exportar.tabla.pdf');
    Route::get('/reportes-biblioteca/exportar-tabla-excel', [ReporteController::class, 'exportarTablaExcel'])->name('reportes.biblioteca.exportar.tabla.excel');
    // Exportar gráficos
    Route::post('/guardar-imagenes-graficos-excel', [ReporteController::class, 'guardarGrafico']);
    Route::post('/guardar-imagenes-graficos', [ReporteController::class, 'guardarGrafico'])->name('reportes.biblioteca.guardar.imagenes');
    Route::get('/reportes-biblioteca/exportar-graficos-pdf', [ReporteController::class, 'exportarGraficosPDF'])->name('reportes.biblioteca.exportar.graficos.pdf');
    Route::get('/reportes-biblioteca/exportar-graficos-excel', [ReporteController::class, 'exportarGraficosExcel'])->name('reportes.biblioteca.exportar.graficos.excel');
});

Route::middleware(['role:admin'])->group(function () {
    // Rutas para administradores
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::middleware(['role:user'])->group(function () {
    // Rutas para usuarios
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});

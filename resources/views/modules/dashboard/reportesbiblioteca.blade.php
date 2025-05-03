{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\reportesbiblioteca.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes Biblioteca')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/reportesbiblioteca.js') }}" defer></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes Biblioteca</h2>
    <p class="text-muted">Filtrar Reportes</p>

    {{-- Filtro de fechas --}}
    <div class="row mb-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="botones col-md-2">
            <input type="text" id="fecha-desde" class="form-control" placeholder="Fecha Desde">
        </div>
        <div class="botones col-md-2">
            <input type="text" id="fecha-hasta" class="form-control" placeholder="Fecha Hasta">
        </div>
        <div class="botones col-md-2">
            <select id="tipo" class="form-select">
                <option value="seleccionar-tipo">Tipo</option>
                <option value="todo">Todo</option>
                <option value="sexo">Sexo</option>
                <option value="turno">Turno</option>
                <option value="carrera">Carrera</option>
                <option value="area_conocimiento">Área de Conocimiento</option>
                <option value="sede">Sede</option>
                <option value="tipo_servicio">Tipo de Servicio</option>
                <option value="sala_atencion">Sala de Atención</option>
                <option value="signatura_topografica">Signatura Topográfica</option>
                <option value="codigo_computadora">Código de Computadora</option>
                <option value="name">Atendido Por</option>
            </select>
        </div>
        <div class="botones col-md-2">
             <select id="categoria" class="form-select" disabled>
                <option value="categoria">Categoría</option>
            </select>
        </div>
        <div class="botones col-md-2">
            <button id="filtrar" class="btn btn-filtrar w-100">Filtrar</button>
        </div>
    </div>

    {{-- Botones de exportación --}}
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button id="exportar-graficos-pdf" class="btn btn-danger">Exportar PDF</button>
            <button id="exportar-graficos-excel" class="btn btn-success">Exportar Excel</button>
        </div>
    </div>

    {{-- Tarjetas informativas --}}
    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <div class="informativas p-3 bg-white">
                <h1 id="total-estudiantes" class="mb-0 fw-bold" style="color: #001C7D;"></h1>
                <p class="mb-0">Estudiantes</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="informativas p-3 bg-white">
                <h1 id="total-docentes" class="mb-0 fw-bold" style="color: #001C7D;"></h1>
                <p class="mb-0">Docentes</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="informativas p-3 bg-white">
                <h1 id="total-servicios" class="mb-0 fw-bold" style="color: #001C7D;"></h1>
                <p class="mb-0">Servicios</p>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-sexo" height="250"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-tipo-servicio" height="250"></canvas>
            </div>
        </div>
        <div class="col-md-12">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-area-conocimiento" height="120"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-sala-atencion" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-carrera" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-turno" width="400" height="250"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 informativas bg-white">
                <canvas id="grafico-sede" width="400" height="250"></canvas>
            </div>
        </div>
    </div>
    
    {{-- Botones de exportación --}}
    <div class="d-flex justify-content-between mb-4 mt-5">
        <div>
            <button id="exportar-tabla-pdf" class="btn btn-danger">Exportar PDF</button>
            <button id="exportar-tabla-excel" class="btn btn-success">Exportar Excel</button>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Carnet</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cédula</th>
                    <th>Turno</th>
                    <th>Sexo</th>
                    <th>Área del Conocimiento</th>
                    <th>Carrera</th>
                    <th>Sede</th>
                    <th>Tipo de Miembro</th>
                    <th>Teléfono</th>
                    <th>Ingreso</th>
                    <th>Número de Locker</th>
                    <th>Sala de Atención</th>
                    <th>Tipo de Servicio</th>
                    <th>Signatura Topográfica</th>
                    <th>Código Computadora</th>
                    <th>Cantidad</th>
                    <th>Atendido por</th>
                </tr>
            </thead>
            <tbody id="tabla-reportes">
                {{-- Los datos se llenarán dinámicamente con JavaScript --}}
            </tbody>
        </table>
    </div>
</div>
@endsection

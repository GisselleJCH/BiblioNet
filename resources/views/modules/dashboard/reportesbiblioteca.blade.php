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
        <div class="botones col-md-4">
            <input type="text" id="fecha-desde" class="form-control" placeholder="Fecha Desde">
        </div>
        <div class="botones col-md-4">
            <input type="text" id="fecha-hasta" class="form-control" placeholder="Fecha Hasta">
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
                <h1 id="total-estudiantes" class="mb-0 fw-bold">0</h1>
                <p class="mb-0">Estudiantes</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="informativas p-3 bg-white">
                <h1 id="total-maestros" class="mb-0 fw-bold">0</h1>
                <p class="mb-0">Maestros</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="informativas p-3 bg-white">
                <h1 id="total-servicios" class="mb-0 fw-bold">0</h1>
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

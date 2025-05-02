@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes CNU')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/reportescnu.js') }}" defer></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes CNU</h2>
    <p class="text-muted">Listado para Consejo Nacional de Universidades</p>

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

    <div class="d-flex justify-content-between mb-3">
        <div>
            <button id="exportar-pdf" class="btn btn-danger">Exportar PDF</button>
            <button id="exportar-excel" class="btn btn-success">Exportar Excel</button>
        </div>
    </div>

    <div class="table-responsive">
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
@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes Control de Servicios')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/buscarservicios.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes de Control de Servicios</h2>
    <p class="text-muted">Listado de Control de Servicios</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4 table-responsive">
                <div class="form-group row">
                    <div class="col-md-12">
                        <input type="text" id="buscarservicios" class="form-control" placeholder="Buscar Control de Servicios">
                    </div>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Carnet</th>
                            <th>Ingreso</th>
                            <th>Número de Locker</th>
                            <th>Sala de Atención</th>
                            <th>Tipo de Servicio</th>
                            <th>Código de Computadora</th>
                            <th>Signatura Topográfica</th>
                            <th>Fecha Devolución</th>
                            <th>Atendido Por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-servicios">
                        @foreach ($servicio as $servicio)
                            <tr>
                                <td>{{ $servicio->miembro->carnet ?? 'N/A' }}</td>
                                <td>{{ $servicio->ingreso }}</td>
                                <td>{{ $servicio->numero_locker }}</td>
                                <td>{{ $servicio->sala_atencion }}</td>
                                <td>{{ $servicio->tipo_servicio }}</td>
                                <td>{{ $servicio->computadora->codigo_computadora ?? 'N/A' }}</td>
                                <td>{{ $servicio->libro->signatura_topografica ?? 'N/A' }}</td>
                                <td>{{ $servicio->fecha_devolucion }}</td>
                                <td>{{ $servicio->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('servicios.editar', $servicio->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('servicios.eliminar', $servicio->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-eliminar">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
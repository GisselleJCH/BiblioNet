@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes de Devoluciones')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/buscardevoluciones.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes de Devoluciones</h2>
    <p class="text-muted">Listado de Devoluciones</p>
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
                        <input type="text" id="buscardevoluciones" class="form-control" placeholder="Buscar Devoluciones">
                    </div>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Carnet del Miembro</th>
                            <th>Usuario que Atendió</th>
                            <th>Tipo de Servicio</th>
                            <th>Código Computadora</th>
                            <th>Signatura Topográfica</th>
                            <th>Cantidad</th>
                            <th>Fecha de Devolución</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                            <th>Control Servicio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-devoluciones">
                        @foreach ($devoluciones as $devolucion)
                            <tr>
                                <td>{{ $devolucion->miembro->carnet ?? 'N/A' }}</td>
                                <td>{{ $devolucion->user->name ?? 'N/A' }}</td>
                                <td>{{ $devolucion->tipo_servicio ?? 'N/A' }}</td>
                                <td>{{ $devolucion->codigo_computadora ?? 'N/A' }}</td>
                                <td>{{ $devolucion->signatura_topografica ?? 'N/A' }}</td>
                                <td>{{ $devolucion->cantidad }}</td>
                                <td>{{ $devolucion->fecha_devolucion }}</td>
                                <td>{{ $devolucion->estado }}</td>
                                <td>{{ $devolucion->observaciones }}</td>
                                <td>{{ $devolucion->control_servicio->tipo_servicio ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('devoluciones.editar', $devolucion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('devoluciones.eliminar', $devolucion->id) }}" method="POST" style="display:inline-block;">
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
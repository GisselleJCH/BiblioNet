@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes de Ingresos')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/buscaringresos.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes de Ingresos</h2>
    <p class="text-muted">Listado de Ingresos</p>
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
                        <input type="text" id="buscaringresos" class="form-control" placeholder="Buscar Ingresos">
                    </div>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Carnet</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cédula</th>
                            <th>Sexo</th>
                            <th>Turno</th>
                            <th>Área del Conocimiento</th>
                            <th>Carrera</th>
                            <th>Sede</th>
                            <th>Tipo de Miembro</th>
                            <th>Acciones</th> <!-- Nueva columna para Acciones -->
                        </tr>
                    </thead>
                    <tbody id="tabla-ingresos">
                        @foreach ($miembros as $miembro)
                            <tr>
                                <td>{{ $miembro->carnet }}</td>
                                <td>{{ $miembro->nombres }}</td>
                                <td>{{ $miembro->apellidos }}</td>
                                <td>{{ $miembro->cedula }}</td>
                                <td>{{ $miembro->sexo }}</td>
                                <td>{{ $miembro->turno }}</td>
                                <td>{{ $miembro->area_conocimiento }}</td>
                                <td>{{ $miembro->carrera }}</td>
                                <td>{{ $miembro->sede }}</td>
                                <td>{{ $miembro->tipo_miembro }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('miembros.editar', $miembro->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('miembros.eliminar', $miembro->id) }}" method="POST" style="display:inline-block;">
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
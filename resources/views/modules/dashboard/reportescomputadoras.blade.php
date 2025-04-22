{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\reportescomputadoras.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes de Computadoras')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/buscarcomputadora.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes de Computadoras</h2>
    <p class="text-muted">Listado de Computadoras</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="fondo p-4 table-responsive">
                <form method="GET" action="{{ route('computadoras.index') }}">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Buscar Computadora" value="{{ request('buscar') }}">
                        </div>
                    </div>
                </form>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Categoría</th>
                            <th>Código de Computadora</th>
                            <th>Cantidad Disponible</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-computadoras">
                        @foreach ($computadoras as $computadora)
                            <tr>
                                <td>{{ $computadora->marca }}</td>
                                <td>{{ $computadora->modelo }}</td>
                                <td>{{ $computadora->categoria }}</td>
                                <td>{{ $computadora->codigo_computadora }}</td>
                                <td>{{ $computadora->cantidad_disponible }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('computadoras.edit', $computadora->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('computadoras.destroy', $computadora->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta computadora?')">Eliminar</button>
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
{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\reporteslibros.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Reportes de Libros')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/buscar.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Reportes de Libros</h2>
    <p class="text-muted">Listado de libros</p>
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
                        <input type="text" id="buscar" class="form-control" placeholder="Buscar libro">
                    </div>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Signatura Topográfica</th>
                            <th>Cantidad Disponible</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-libros">
                        @foreach ($libros as $libro)
                            <tr>
                                <td>{{ $libro->titulo }}</td>
                                <td>{{ $libro->autor }}</td>
                                <td>{{ $libro->categoria }}</td>
                                <td>{{ $libro->signatura_topografica }}</td>
                                <td>{{ $libro->cantidad_disponible }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('libros.edit', $libro->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('libros.destroy', $libro->id) }}" method="POST" style="display:inline-block;">
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
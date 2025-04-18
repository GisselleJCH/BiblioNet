{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\libros.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Libros')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Libros</h2>
    <p class="text-muted">Registro de libros</p>
    <hr>
    <div class="row">
        <div class="col-md-10">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form method="POST" action="{{ route('libros.store') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="titulo" class="col-form-label fw-bold">Título</label>
                            <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="signatura_topografica" class="col-form-label fw-bold">Signatura Topográfica</label>
                            <input id="signatura_topografica" type="text" class="form-control @error('signatura_topografica') is-invalid @enderror" name="signatura_topografica" value="{{ old('signatura_topografica') }}" required>
                            @error('signatura_topografica')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="autor" class="col-form-label fw-bold">Autor</label>
                            <input id="autor" type="text" class="form-control @error('autor') is-invalid @enderror" name="autor" value="{{ old('autor') }}" required>
                            @error('autor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad_disponible" class="col-form-label fw-bold">Cantidad</label>
                            <input id="cantidad_disponible" type="number" class="form-control @error('cantidad_disponible') is-invalid @enderror" name="cantidad_disponible" value="{{ old('cantidad_disponible', 1) }}" required>
                            @error('cantidad_disponible')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="categoria" class="col-form-label fw-bold">Categoría</label>
                            <select id="categoria" class="form-control @error('categoria') is-invalid @enderror" name="categoria" required>
                                <option value="">Seleccionar</option>
                                <option value="Generalidades">Generalidades</option>
                                <option value="Filosofía y Psicología">Filosofía y Psicología</option>
                                <option value="Ciencias Sociales">Ciencias Sociales</option>
                                <option value="Ciencias Naturales y Matemáticas">Ciencias Naturales y Matemáticas</option>
                                <option value="Lengua">Lengua</option>
                                <option value="Tecnología y Ciencias Aplicadas">Tecnología y Ciencias Aplicadas</option>
                                <option value="Artes, Bellas Artes y Artes Decorativas">Artes, Bellas Artes y Artes Decorativas</option>
                            </select>
                            @error('categoria')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-4 justify-content-end">
                        <div class="col-md-2">
                            <a href="{{ route('home') }}" class="btn boton_cancelar w-100">Cancelar</a>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn boton_agregar w-100">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Validación de errores -->
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Error',
            text: "{{ $errors->first() }}",
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif
{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\editcomputadoras.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Editar Computadora')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Editar Computadora</h2>
    <p class="text-muted">Formulario para editar una computadora</p>
    <hr>

    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form method="POST" action="{{ route('computadoras.update', $computadora->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="marca" class="col-form-label fw-bold">Marca</label>
                            <input id="marca" type="text" class="form-control @error('marca') is-invalid @enderror" name="marca" value="{{ $computadora->marca }}" required>
                            @error('marca')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="modelo" class="col-form-label fw-bold">Modelo</label>
                            <input id="modelo" type="text" class="form-control @error('modelo') is-invalid @enderror" name="modelo" value="{{ $computadora->modelo }}" required>
                            @error('modelo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Código de Computadora y Cantidad --}}
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="codigo_computadora" class="col-form-label fw-bold">Código de Computadora</label>
                            <input id="codigo_computadora" type="text" class="form-control @error('codigo_computadora') is-invalid @enderror" name="codigo_computadora" value="{{ $computadora->codigo_computadora }}" required>
                            @error('codigo_computadora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cantidad_disponible" class="col-form-label fw-bold">Cantidad</label>
                            <input id="cantidad_disponible" type="number" class="form-control @error('cantidad_disponible') is-invalid @enderror" name="cantidad_disponible" value="{{ $computadora->cantidad_disponible }}" required>
                            @error('cantidad_disponible')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Categoría --}}
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="categoria" class="col-form-label fw-bold">Categoría</label>
                            <select id="categoria" class="form-control @error('categoria') is-invalid @enderror" name="categoria" required>
                                <option value="">Seleccionar</option>
                                <option value="Laptop" {{ $computadora->categoria == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="Escritorio" {{ $computadora->categoria == 'Escritorio' ? 'selected' : '' }}>Escritorio</option>
                            </select>
                            @error('categoria')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="form-group row mt-4 justify-content-end">
                        <div class="col-md-2">
                            <a href="{{ route('computadoras.reportes') }}" class="btn boton_cancelar w-100">Cancelar</a>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn boton_agregar w-100">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Validación de errores --}}
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Error',
            html: `
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif
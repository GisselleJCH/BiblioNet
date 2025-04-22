@extends('layouts.estructura')

@section('titulo_pagina', 'Computadoras')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/computadoras.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Computadoras</h2>
    <p class="text-muted">Registro de Computadoraa</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form id="computadorasForm" data-action="{{ route('computadoras.store') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="marca" class="col-form-label fw-bold">Marca</label>
                            <input id="marca" type="text" class="form-control" name="marca" required>
                            @error('marca')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="categoria" class="col-form-label fw-bold">Categoría</label>
                            <select id="categoria" class="form-control @error('categoria') is-invalid @enderror" name="categoria" required>
                                <option value="">Seleccionar</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Escritorio">Escritorio</option>
                            </select>    
                            @error('categoria')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="modelo" class="col-form-label fw-bold">Modelo</label>
                            <input id="modelo" type="text" class="form-control" name="modelo" required>
                            @error('modelo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="codigo_computadora" class="col-form-label fw-bold">Código de Computadora</label>
                            <input id="codigo_computadora" type="text" class="form-control" name="codigo_computadora" required>
                            @error('codigo_computadora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="cantidad_disponible" class="col-form-label fw-bold">Cantidad Disponible</label>
                            <input id="cantidad_disponible" type="number" class="form-control" name="cantidad_disponible" min="1" value="1" required>
                        @error('cantidad_disponible')
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
                            <button type="submit" class="btn boton_agregar w-100">Registrar</button>
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
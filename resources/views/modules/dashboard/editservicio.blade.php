@extends('layouts.estructura')

@section('titulo_pagina', 'Editar Control de Servicios')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Editar Control de Servicios</h2>
    <p class="text-muted">Formulario para editar Control de Servicios</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form method="POST" action="{{ route('servicios.editar', $servicio->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="miembro_id" class="col-form-label fw-bold">Carnet</label>
                            <input id="miembro_id" type="text" class="form-control @error('miembro_id') is-invalid @enderror" 
                                name="miembro_id" value="{{ $servicio->miembro->carnet ?? 'N/A' }}" required>
                            @error('miembro_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ingreso" class="col-form-label fw-bold">Ingreso</label>
                            <input id="ingreso" type="text" class="form-control @error('ingreso') is-invalid @enderror" name="ingreso" value="{{ $servicio->ingreso }}" required>
                            @error('ingreso')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="numero_locker" class="col-form-label fw-bold">Número de Locker</label>
                            <input id="numero_locker" type="text" class="form-control @error('numero_locker') is-invalid @enderror" name="numero_locker" value="{{ $servicio->numero_locker }}" required>
                            @error('numero_locker')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="sala_atencion" class="col-form-label fw-bold">Sala de Atención</label>
                           <select id="sala_atencion" class="form-control @error('sala_atencion') is-invalid @enderror" name="sala_atencion" required>
                                <option value="">Seleccionar</option>
                                <option value="Sala de lectura" {{ $servicio->sala_atencion == 'Sala de lectura' ? 'selected' : '' }}>Sala de lectura</option>
                                <option value="Sala de computación" {{ $servicio->sala_atencion == 'Sala de computación' ? 'selected' : '' }}>Sala de computación</option>
                                <option value="Sala de hemeroteca" {{ $servicio->sala_atencion == 'Sala de hemeroteca' ? 'selected' : '' }}>Sala de hemeroteca</option>
                                <option value="Sala wifi" {{ $servicio->sala_atencion == 'Sala wifi' ? 'selected' : '' }}>Sala wifi</option>
                                <option value="Sala de atención al usuario" {{ $servicio->sala_atencion == 'Sala de atención al usuario' ? 'selected' : '' }}>Sala de atención al usuario</option>
                                <option value="Auditorio" {{ $servicio->sala_atencion == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                            </select>
                            @error('sala_atencion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="tipo_servicio" class="col-form-label fw-bold">Tipo de Servicio</label>
                            <select id="tipo_servicio" class="form-control @error('tipo_servicio') is-invalid @enderror" name="tipo_servicio" required>
                                <option value="">Seleccionar</option>
                                <option value="Lectura de Material Bibliográfico en Físico" {{ $servicio->tipo_servicio == 'Lectura de Material Bibliográfico en Físico' ? 'selected' : '' }}>Lectura de Material Bibliográfico en Físico</option>
                                <option value="Préstamo de Material Bibliográfico a domicilio" {{ $servicio->tipo_servicio == 'Préstamo de Material Bibliográfico a domicilio' ? 'selected' : '' }}>Préstamo de Material Bibliográfico a domicilio</option>
                                <option value="Escaneo Impresión" {{ $servicio->tipo_servicio == 'Escaneo Impresión' ? 'selected' : '' }}>Escaneo Impresión</option>
                                <option value="Préstamo de Computadora" {{ $servicio->tipo_servicio == 'Préstamo de Computadora' ? 'selected' : '' }}>Préstamo de Computadora</option>
                                <option value="Entrega de solvencia" {{ $servicio->tipo_servicio == 'Entrega de solvencia' ? 'selected' : '' }}>Entrega de solvencia</option>
                                <option value="Usuario con suscripción" {{ $servicio->tipo_servicio == 'Usuario con suscripción' ? 'selected' : '' }}>Usuario con suscripción</option>
                                <option value="Capacitación a Usuarios" {{ $servicio->tipo_servicio == 'Capacitación a Usuarios' ? 'selected' : '' }}>Capacitación a Usuarios</option>
                            </select>
                            @error('tipo_servicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="computadora_id" class="col-form-label fw-bold">Código de Computadora</label>
                            <input id="computadora_id" type="text" class="form-control @error('computadora_id') is-invalid @enderror" 
                                name="computadora_id" value="{{ $servicio->computadora->codigo_computadora ?? 'N/A' }}" required>
                            @error('computadora_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="libro_id" class="col-form-label fw-bold">Signatura Topográfica</label>
                            <input id="libro_id" type="text" class="form-control @error('libro_id') is-invalid @enderror" 
                                name="libro_id" value="{{ $servicio->libro->signatura_topografica ?? 'N/A' }}" required>
                            @error('libro_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_devolucion" class="col-form-label fw-bold">Fecha Devolución</label>
                            <input id="fecha_devolucion" type="text" class="form-control @error('fecha_devolucion') is-invalid @enderror" name="fecha_devolucion" value="{{ $servicio->fecha_devolucion }}" required>
                            @error('fecha_devolucion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="atendido_por" class="col-form-label fw-bold">Atendido Por</label>
                            <input id="atendido_por" type="text" class="form-control @error('atendido_por') is-invalid @enderror" 
                                name="atendido_por" value="{{ $servicio->user->name ?? 'N/A' }}" required>
                            @error('atendido_por')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones: Cancelar y Actualizar -->
                    <div class="form-group row mt-4 justify-content-end">
                        <div class="col-md-2">
                            <a href="{{ route('servicios.reportes') }}" class="btn boton_cancelar w-100">Cancelar</a>
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
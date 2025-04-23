@extends('layouts.estructura')

@section('titulo_pagina', 'Editar Devoluciones')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Editar Devoluciones</h2>
    <p class="text-muted">Formulario para editar Devoluciones</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form method="POST" action="{{ route('devoluciones.actualizar', $devolucion->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="miembro_id" class="col-form-label fw-bold">Carnet del Miembro</label>
                            <select id="miembro_id" class="form-control @error('miembro_id') is-invalid @enderror" name="miembro_id" required>
                                <option value="">Seleccionar</option>
                                @foreach ($controlServicios as $controlServicio)
                                    <option value="{{ $controlServicio->miembro_id }}" {{ $devolucion->miembro_id == $controlServicio->miembro_id ? 'selected' : '' }}>
                                        {{ $controlServicio->miembro->carnet ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('miembro_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="usuario_atendio" class="col-form-label fw-bold">Usuario que Atendió</label>
                            <select id="usuario_atendio" class="form-control @error('usuario_atendio') is-invalid @enderror" name="usuario_atendio" required>
                                <option value="">Seleccionar</option>
                                @foreach ($controlServicios as $controlServicio)
                                    <option value="{{ $controlServicio->user->id }}" {{ $devolucion->usuario_atendio == $controlServicio->user->id ? 'selected' : '' }}>
                                        {{ $controlServicio->user->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_atendio')
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
                                <option value="Lectura de Material Bibliográfico en Físico" {{ $devolucion->tipo_servicio ?? 'N/A' == 'Lectura de Material Bibliográfico en Físico' ? 'selected' : '' }}>Lectura de Material Bibliográfico en Físico</option>
                                <option value="Préstamo de Material Bibliográfico a domicilio" {{ $devolucion->tipo_servicio ?? 'N/A' == 'Préstamo de Material Bibliográfico a domicilio' ? 'selected' : '' }}>Préstamo de Material Bibliográfico a domicilio</option>
                                <option value="Préstamo de Computadora" {{ $devolucion->tipo_servicio ?? 'N/A' == 'Préstamo de Computadora' ? 'selected' : '' }}>Préstamo de Computadora</option>
                            </select>
                            @error('tipo_servicio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="codigo_computadora" class="col-form-label fw-bold">Código de Computadora</label>
                            <input id="codigo_computadora" type="text" class="form-control @error('codigo_computadora') is-invalid @enderror" name="codigo_computadora" value="{{ $devolucion->codigo_computadora ?? 'N/A' }}" required>
                            @error('codigo_computadora')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="signatura_topografica" class="col-form-label fw-bold">Signatura Topográfica</label>
                            <input id="signatura_topografica" type="text" class="form-control @error('signatura_topografica') is-invalid @enderror" name="signatura_topografica" value="{{ $devolucion->signatura_topografica ?? 'N/A' }}" required>
                            @error('signatura_topografica')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cantidad" class="col-form-label fw-bold">Cantidad</label>
                            <input id="cantidad" type="number" class="form-control @error('cantidad') is-invalid @enderror" name="cantidad" value="{{ $devolucion->cantidad }}" required>
                            @error('cantidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="fecha_devolucion" class="col-form-label fw-bold">Fecha Devolución</label>
                            <input id="fecha_devolucion" type="text" class="form-control @error('fecha_devolucion') is-invalid @enderror" name="fecha_devolucion" value="{{ $devolucion->fecha_devolucion }}" required>
                            @error('fecha_devolucion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="estado" class="col-form-label fw-bold">Estado</label>
                            <select id="estado" class="form-control @error('estado') is-invalid @enderror" name="estado" required>
                                <option value="">Seleccionar</option>
                                <option value="devuelto" {{ $devolucion->estado == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                                <option value="extraviado" {{ $devolucion->estado == 'extraviado' ? 'selected' : '' }}>Extraviado</option>
                                <option value="dañado" {{ $devolucion->estado == 'dañado' ? 'selected' : '' }}>Dañado</option>
                            </select>
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="observaciones" class="col-form-label fw-bold">Observaciones</label>
                            <input id="observaciones" type="text" class="form-control @error('observaciones') is-invalid @enderror" name="observaciones" value="{{ $devolucion->observaciones }}" required>
                            @error('observaciones')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="control_servicio_id" class="col-form-label fw-bold">Control Servicio</label>
                            <select id="control_servicio_id" class="form-control @error('control_servicio_id') is-invalid @enderror" name="control_servicio_id" required>
                                <option value="">Seleccionar</option>
                                @foreach ($controlServicios as $controlServicio)
                                    <option value="{{ $controlServicio->id }}" {{ $devolucion->control_servicio_id == $controlServicio->id ? 'selected' : '' }}>
                                        {{ $controlServicio->tipo_servicio }}
                                    </option>
                                @endforeach
                            </select>
                            @error('control_servicio_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones: Cancelar y Actualizar -->
                    <div class="form-group row mt-4 justify-content-end">
                        <div class="col-md-2">
                            <a href="{{ route('reportes.devoluciones') }}" class="btn boton_cancelar w-100">Cancelar</a>
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
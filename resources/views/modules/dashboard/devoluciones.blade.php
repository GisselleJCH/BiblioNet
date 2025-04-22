{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\devoluciones.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Devoluciones')

@section('contenido')
<script>
    const obtenerPrestamosUrl = "{{ route('prestamos.obtener') }}";
</script>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/devoluciones.js') }}" defer></script>

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Devoluciones</h2>
    <p class="text-muted">Registra devoluciones de préstamos de libros y computadoras</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form id="form-devolucion" method="POST" action="{{ route('devoluciones.store') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="carnet_miembro" class="col-form-label fw-bold">Carnet del Miembro</label>
                            <select id="carnet_miembro" class="form-control" name="carnet" required>
                                <option value="">Seleccionar</option>
                                @foreach ($miembros as $miembro)
                                    <option value="{{ $miembro->carnet }}">{{ $miembro->carnet }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="usuario_atendio" class="col-form-label fw-bold">Nombre del Usuario que Atendió</label>
                            <select id="usuario_atendio" class="form-control" name="usuario_atendio" required>
                                <option value="">Seleccionar</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->name }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="tipo_servicio" class="col-form-label fw-bold">Tipo de Servicio</label>
                            <select id="tipo_servicio" class="form-control" name="tipo_servicio" required>
                                <option value="">Seleccionar</option>
                                <option value="Préstamo de Material Bibliográfico a domicilio">Préstamo de Material Bibliográfico a domicilio</option>
                                <option value="Lectura de Material Bibliográfico en Físico">Lectura de Material Bibliográfico en Físico</option>
                                <option value="Préstamo de Computadora">Préstamo de Computadora</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="control_servicio_id" class="col-form-label fw-bold">Préstamo</label>
                            <select id="control_servicio_id" class="form-control" name="control_servicio_id" required>
                                <option value="">Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="cantidad" class="col-form-label fw-bold">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="col-form-label fw-bold">Estado</label>
                            <select id="estado" class="form-control" name="estado" required>
                                <option value="">Seleccionar</option>
                                <option value="devuelto">Devuelto</option>
                                <option value="extraviado">Extraviado</option>
                                <option value="dañado">Dañado</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="observaciones" class="col-form-label fw-bold">Observaciones</label>
                            <textarea id="observaciones" class="form-control" name="observaciones" rows="3" placeholder="Escribe observaciones"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mt-4 justify-content-end">
                        <div class="col-md-2">
                            <a href="{{ route('home') }}" class="btn boton_cancelar w-100">Cancelar</a>
                        </div>
                        <div class="col-md-2">
                            <button id="btn-registrar-devolucion" type="submit" class="btn boton_agregar w-100" data-url="{{ route('prestamos.obtener') }}">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
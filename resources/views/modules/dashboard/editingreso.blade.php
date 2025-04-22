@extends('layouts.estructura')

@section('titulo_pagina', 'Editar Ingreso')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Editar Ingreso</h2>
    <p class="text-muted">Formulario para editar un ingreso</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form method="POST" action="{{ route('miembros.actualizar', $miembros->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="carnet" class="col-form-label fw-bold">Carnet</label>
                            <input type="text" class="form-control" id="carnet" name="carnet" value="{{ old('carnet', $miembros->carnet) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nombres" class="col-form-label fw-bold">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres', $miembros->nombres) }}" required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="apellidos" class="col-form-label fw-bold">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos', $miembros->apellidos) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cedula" class="col-form-label fw-bold">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" value="{{ old('cedula', $miembros->cedula) }}" required>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="sexo"class="col-form-label fw-bold">Sexo</label>
                            <select class="form-control" id="sexo" name="sexo" required>
                                <option value="Masculino" {{ old('sexo', $miembros->sexo) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('sexo', $miembros->sexo) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="turno" class="col-form-label fw-bold">Turno</label>
                            <select class="form-control" id="turno" name="turno" required>
                                <option value="Matutino" {{ old('turno', $miembros->turno) == 'Matutino' ? 'selected' : '' }}>Matutino</option>
                                <option value="Vespertino" {{ old('turno', $miembros->turno) == 'Vespertino' ? 'selected' : '' }}>Vespertino</option>
                                <option value="Nocturno" {{ old('turno', $miembros->turno) == 'Nocturno' ? 'selected' : '' }}>Nocturno</option>
                                <option value="Sabatino" {{ old('turno', $miembros->turno) == 'Sabatino' ? 'selected' : '' }}>Sabatino</option>
                                <option value="Dominical" {{ old('turno', $miembros->turno) == 'Dominical' ? 'selected' : '' }}>Dominical</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="area_conocimiento" class="col-form-label fw-bold">Área del Conocimiento</label>
                            <select class="form-control" id="area_conocimiento" name="area_conocimiento" required>
                                <option value="Dirección Educación, Arte y Humanidades" {{ old('area_conocimiento', $miembros->area_conocimiento) == 'Dirección Educación, Arte y Humanidades' ? 'selected' : '' }}>Dirección Educación, Arte y Humanidades</option>
                                <option value="Dirección Ciencias de la Salud" {{ old('area_conocimiento', $miembros->area_conocimiento) == 'Dirección Ciencias de la Salud' ? 'selected' : '' }}>Dirección Ciencias de la Salud</option>
                                <option value="Dirección Ciencias Básicas y Tecnología" {{ old('area_conocimiento', $miembros->area_conocimiento) == 'Dirección Ciencias Básicas y Tecnología' ? 'selected' : '' }}>Dirección Ciencias Básicas y Tecnología</option>
                                <option value="Dirección Ciencias Sociales, Económicas Administrativas y Ciencias Jurídicas" {{ old('area_conocimiento', $miembros->area_conocimiento) == 'Dirección Ciencias Sociales, Económicas Administrativas y Ciencias Jurídicas' ? 'selected' : '' }}>Dirección Ciencias Sociales, Económicas Administrativas y Ciencias Jurídicas</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="carrera" class="col-form-label fw-bold">Carrera</label>
                            <select class="form-control" id="carrera" name="carrera" required>
                                <option value="Diseño de Producto" {{ old('carrera', $miembros->carrera) == 'Diseño de Producto' ? 'selected' : '' }}>Diseño de Producto</option>
                                <option value="Diseño Integral de Comunicación" {{ old('carrera', $miembros->carrera) == 'Diseño Integral de Comunicación' ? 'selected' : '' }}>Diseño Integral de Comunicación</option>
                                <option value="Producción de Espectáculos" {{ old('carrera', $miembros->carrera) == 'Producción de Espectáculos' ? 'selected' : '' }}>Producción de Espectáculos</option>
                                <option value="Inglés" {{ old('carrera', $miembros->carrera) == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                                <option value="Enseñanza Artística Musical" {{ old('carrera', $miembros->carrera) == 'Enseñanza Artística Musical' ? 'selected' : '' }}>Enseñanza Artística Musical</option>
                                <option value="Enseñanza Artística Musical con Mención en Violín" {{ old('carrera', $miembros->carrera) == 'Enseñanza Artística Musical con Mención en Violín' ? 'selected' : '' }}>Enseñanza Artística Musical con Mención en Violín</option>
                                <option value="Enfermería" {{ old('carrera', $miembros->carrera) == 'Enfermería' ? 'selected' : '' }}>Enfermería</option>
                                <option value="Técnico Superior en Enfermería" {{ old('carrera', $miembros->carrera) == 'Técnico Superior en Enfermería' ? 'selected' : '' }}>Técnico Superior en Enfermería</option>
                                <option value="Gastronomía con Arte Culinario" {{ old('carrera', $miembros->carrera) == 'Gastronomía con Arte Culinario' ? 'selected' : '' }}>Gastronomía con Arte Culinario</option>
                                <option value="Administración Turística y Hotelera" {{ old('carrera', $miembros->carrera) == 'Administración Turística y Hotelera' ? 'selected' : '' }}>Administración Turística y Hotelera</option>
                                <option value="Ingeniería en Sistemas de Información" {{ old('carrera', $miembros->carrera) == 'Ingeniería en Sistemas de Información' ? 'selected' : '' }}>Ingeniería en Sistemas de Información</option>
                                <option value="Ingeniería en Computación" {{ old('carrera', $miembros->carrera) == 'Ingeniería en Computación' ? 'selected' : '' }}>Ingeniería en Computación</option>
                                <option value="Ingeniería en Biotecnología" {{ old('carrera', $miembros->carrera) == 'Ingeniería en Biotecnología' ? 'selected' : '' }}>Ingeniería en Biotecnología</option>
                                <option value="Mercadotecnia" {{ old('carrera', $miembros->carrera) == 'Mercadotecnia' ? 'selected' : '' }}>Mercadotecnia</option>
                                <option value="Contaduría Pública y Finanzas" {{ old('carrera', $miembros->carrera) == 'Contaduría Pública y Finanzas' ? 'selected' : '' }}>Contaduría Pública y Finanzas</option>
                                <option value="Administración de Empresas" {{ old('carrera', $miembros->carrera) == 'Administración de Empresas' ? 'selected' : '' }}>Administración de Empresas</option>
                                <option value="Economía y Negocios" {{ old('carrera', $miembros->carrera) == 'Economía y Negocios' ? 'selected' : '' }}>Economía y Negocios</option>
                                <option value="Finanzas y Gestión Bancaria" {{ old('carrera', $miembros->carrera) == 'Finanzas y Gestión Bancaria' ? 'selected' : '' }}>Finanzas y Gestión Bancaria</option>
                                <option value="Derecho" {{ old('carrera', $miembros->carrera) == 'Derecho' ? 'selected' : '' }}>Derecho</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="sede" class="col-form-label fw-bold">Sede</label>
                            <select class="form-control" id="sede" name="sede" required>
                                <option value="UNP Central" {{ old('sede', $miembros->sede) == 'UNP Central' ? 'selected' : '' }}>UNP Central</option>
                                <option value="UNP Extensión-Teustepe" {{ old('sede', $miembros->sede) == 'UNP Extensión-Teustepe' ? 'selected' : '' }}>UNP Extensión-Teustepe</option>
                                <option value="UNP CUR-Boaco" {{ old('sede', $miembros->sede) == 'UNP CUR-Boaco' ? 'selected' : '' }}>UNP CUR-Boaco</option>
                                <option value="UNP CUR-Estelí" {{ old('sede', $miembros->sede) == 'UNP CUR-Estelí' ? 'selected' : '' }}>UNP CUR-Estelí</option>
                                <option value="UNP CUR-Rivas" {{ old('sede', $miembros->sede) == 'UNP CUR-Rivas' ? 'selected' : '' }}>UNP CUR-Rivas</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_miembro" class="col-form-label fw-bold">Tipo de Miembro</label>
                            <select class="form-control" id="tipo_miembro" name="tipo_miembro" required>
                                <option value="Estudiante" {{ old('tipo_miembro', $miembros->tipo_miembro) == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="Maestro" {{ old('tipo_miembro', $miembros->tipo_miembro) == 'Maestro' ? 'selected' : '' }}>Maestro</option>
                            </select>
                        </div>
                    </div>

                     <!-- Botones: Cancelar y Actualizar -->
                    <div class="form-group row mt-4 justify-content-end">
                        <div class="col-md-2">
                            <a href="{{ route('miembros.reportes') }}" class="btn boton_cancelar w-100">Cancelar</a>
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
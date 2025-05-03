{{-- filepath: c:\laragon\www\biblioteca\resources\views\modules\dashboard\controlservicios.blade.php --}}
@extends('layouts.estructura')

@section('titulo_pagina', 'Control de Servicios')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script type="text/javascript" src="{{ asset('js/controlservicios.js') }}" defer></script>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold" style="color: #001C7D;">Control de Ingresos y Servicios</h2>
            <p class="text-muted">Registro de Ingresos y Servicios</p>
        </div>
        <div class="input-group" style="max-width: 500px;">
            <input id="search-carnet" type="text" class="form-control" placeholder="Buscar registros">
            <div id="search-suggestions" class="list-group position-absolute w-100"></div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form method="POST" action="{{ route('servicios.services') }}">
                    @csrf
                    <input type="hidden" id="miembro_id" name="miembro_id">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="carnet" class="col-form-label fw-bold">Carnet</label>
                            <input id="carnet" type="text" class="form-control" name="carnet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="sexo" class="col-form-label fw-bold">Sexo</label>
                            <input id="sexo" type="text" class="form-control" name="sexo" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="nombres" class="col-form-label fw-bold">Nombres</label>
                            <input id="nombres" type="text" class="form-control" name="nombres" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="col-form-label fw-bold">Apellidos</label>
                            <input id="apellidos" type="text" class="form-control" name="apellidos" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="cedula" class="col-form-label fw-bold">Cédula</label>
                            <input id="cedula" type="text" class="form-control" name="cedula" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="carrera" class="col-form-label fw-bold">Carrera</label>
                            <input id="carrera" type="text" class="form-control" name="carrera" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="turno" class="col-form-label fw-bold">Turno</label>
                            <input id="turno" type="text" class="form-control" name="turno" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="area_conocimiento" class="col-form-label fw-bold">Área del Conocimiento</label>
                            <input id="area_conocimiento" type="text" class="form-control" name="area_conocimiento" readonly>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="sede" class="col-form-label fw-bold">Sede</label>
                            <input id="sede" type="text" class="form-control" name="sede" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_miembro" class="col-form-label fw-bold">Tipo de Miembro</label>
                            <input id="tipo_miembro" type="text" class="form-control" name="tipo_miembro" readonly>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-md-6">
                            <label for="telefono" class="col-form-label fw-bold">Teléfono</label>
                            <input id="telefono" type="text" class="form-control" name="telefono" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="ingreso" class="col-form-label fw-bold">Ingreso</label>
                            <input id="ingreso" type="text" class="form-control" name="ingreso" value="{{ now() }}" readonly>
                        </div>
                    </div>
                        <div class="form-group row mt-3">
                            <div class="col-md-6">
                                <label for="numero_locker" class="col-form-label fw-bold">Número de Locker</label>
                                <select id="numero_locker" class="form-control" name="numero_locker">
                                    <option value="">Seleccionar</option>
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label for="sala_atencion" class="col-form-label fw-bold">Sala de Atención</label>
                                <select id="sala_atencion" class="form-control" name="sala_atencion" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Sala de lectura">Sala de lectura</option>
                                    <option value="Sala de computación">Sala de computación</option>
                                    <option value="Sala de hemeroteca">Sala de hemeroteca</option>
                                    <option value="Sala wifi">Sala wifi</option>
                                    <option value="Sala de atención al usuario">Sala de atención al usuario</option>
                                    <option value="Auditorio">Auditorio</option>
                                </select>
                            </div>
                        </div>

                    <div class="form-group row mt-3" id="extra-fields">
                    </div>
                    <div class="form-group row mt-2">
                            <div class="col-md-6">
                                <label for="tipo_servicio" class="col-form-label fw-bold">Tipo de Servicio</label>
                                <select id="tipo_servicio" class="form-control" name="tipo_servicio" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Lectura de Material Bibliográfico en Físico">Lectura de Material Bibliográfico en Físico</option>
                                    <option value="Préstamo de Material Bibliográfico a domicilio">Préstamo de Material Bibliográfico a domicilio</option>
                                    <option value="Escaneo Impresión">Escaneo Impresión</option>
                                    <option value="Préstamo de Computadora">Préstamo de Computadora</option>
                                    <option value="Entrega de solvencia">Entrega de solvencia</option>
                                    <option value="Usuario con suscripción">Usuario con suscripción</option>
                                    <option value="Capacitación a Usuarios">Capacitación a Usuarios</option>
                                    <option value="Atención de Usuario">Atención de Usuario (Recepción)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_atendio" class="col-form-label fw-bold">Atendido por</label>
                                <select id="usuario_atendio" class="form-control" name="usuario_atendio" required>
                                    <option value="">Seleccionar</option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                    @endforeach
                                </select>
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

<!-- Modal para registrar nuevo usuario -->
<div class="modal fade" id="registerMiembrosModal" tabindex="-1" aria-labelledby="registerMiembrosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-bold" id="registerMiembrosModalLabel" style="color: #001C7D;">Registrar Nuevo Miembro</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerMiembrosForm" method="POST" action="{{ route('miembros.registrarMiembro') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-carnet" class="col-form-label fw-bold">Carnet:</label>
                                <input type="text" class="form-control" id="modal-carnet" name="carnet" placeholder="Carnet" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-sexo" class="col-form-label fw-bold">Sexo:</label>
                                <select class="form-control" id="modal-sexo" name="sexo" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-nombres" class="col-form-label fw-bold">Nombres:</label>
                                <input type="text" class="form-control" id="modal-nombres" name="nombres" placeholder="Nombres" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-area_conocimiento" class="col-form-label fw-bold">Área del Conocimiento:</label>
                                <select class="form-control" id="modal-area_conocimiento" name="area_conocimiento" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Dirección Educación, Arte y Humanidades">Dirección Educación, Arte y Humanidades</option>
                                    <option value="Dirección Ciencias de la Salud">Dirección Ciencias de la Salud</option>
                                    <option value="Dirección Ciencias Básicas y Tecnología">Dirección Ciencias Básicas y Tecnología</option>
                                    <option value="Dirección Ciencias Sociales, Económicas Administrativas y Jurídicas">Dirección Ciencias Sociales, Económicas Administrativas y Jurídicas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-apellidos" class="col-form-label fw-bold">Apellidos:</label>
                                <input type="text" class="form-control" id="modal-apellidos" name="apellidos" placeholder="Apellidos" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-sede" class="col-form-label fw-bold">Sede:</label>
                                <select class="form-control" id="modal-sede" name="sede" required>
                                    <option value="">Seleccionar</option>
                                    <option value="UNP Central">UNP Central</option>
                                    <option value="UNP Extensión-Teustepe">UNP Extensión-Teustepe</option>
                                    <option value="UNP CUR-Boaco">UNP CUR-Boaco</option>
                                    <option value="UNP CUR-Estelí">UNP CUR-Estelí</option>
                                    <option value="UNP CUR-Rivas">UNP CUR-Rivas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-cedula" class="col-form-label fw-bold">Cédula:</label>
                                <input type="text" class="form-control" id="modal-cedula" name="cedula" placeholder="Cédula" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-carrera" class="col-form-label fw-bold">Carrera:</label>
                                <select class="form-control" id="modal-carrera" name="carrera" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Diseño de Producto">Diseño de Producto</option>
                                    <option value="Diseño Integral de Comunicación">Diseño Integral de Comunicación</option>
                                    <option value="Producción de Espectáculos">Producción de Espectáculos</option>
                                    <option value="Inglés">Inglés</option>
                                    <option value="Enseñanza Artística Musical">Enseñanza Artística Musical</option>
                                    <option value="Enseñanza Artística Musical con Mención en Violín">Enseñanza Artística Musical con Mención en Violín</option>
                                    <option value="Enfermería">Enfermería</option>
                                    <option value="Técnico Superior en Enfermería">Técnico Superior en Enfermería</option>
                                    <option value="Gastronomía con Arte Culinario">Gastronomía con Arte Culinario</option>
                                    <option value="Administración Turística y Hotelera">Administración Turística y Hotelera</option>
                                    <option value="Ingeniería en Sistemas de Información">Ingeniería en Sistemas de Información</option>
                                    <option value="Ingeniería en Computación">Ingeniería en Computación</option>
                                    <option value="Ingeniería en Biotecnología">Ingeniería en Biotecnología</option>
                                    <option value="Mercadotecnia">Mercadotecnia</option>
                                    <option value="Contaduría Pública y Finanzas">Contaduría Pública y Finanzas</option>
                                    <option value="Administración de Empresas">Administración de Empresas</option>
                                    <option value="Economía y Negocios">Economía y Negocios</option>
                                    <option value="Finanzas y Gestión Bancaria">Finanzas y Gestión Bancaria</option>
                                    <option value="Derecho">Derecho</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-turno" class="col-form-label fw-bold">Turno:</label>
                                <select class="form-control" id="modal-turno" name="turno" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Matutino">Matutino</option>
                                    <option value="Vespertino">Vespertino</option>
                                    <option value="Nocturno">Nocturno</option>
                                    <option value="Sabatino">Sabatino</option>
                                    <option value="Dominical">Dominical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-tipo_miembro" class="col-form-label fw-bold">Tipo de Miembro:</label>
                                    <select class="form-control" id="modal-tipo_miembro" name="tipo_miembro" required>
                                        <option value="">Seleccionar</option>
                                        <option value="Estudiante">Estudiante</option>
                                        <option value="Docente">Docente</option>
                                        <option value="Personal Administrativo">Personal Administrativo</option>
                                    </select>
                                </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="modal-telefono" class="col-form-label fw-bold">Teléfono:</label>
                                <input type="text" class="form-control" id="modal-telefono" name="telefono" placeholder="Teléfono" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton_cancelar" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn boton_agregar" id="saveMiembrosButton">Registrar</button>
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
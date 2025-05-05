@extends('layouts.estructura')

@section('titulo_pagina', 'Datos Miembros')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Datos Miembros</h2>
    <p class="text-muted">Importar los datos al Sistema</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="fondo p-4">
                <form action="{{ route('miembros.importar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="archivo">Subir archivo Excel</label>
                        <br>
                        <input type="file" name="archivo" id="archivo" accept=".xlsx, .xls, .csv" required>
                    </div>
                    <button type="submit" class="btn boton_agregar mt-3">Importar</button>
                </form>
                <hr>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
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
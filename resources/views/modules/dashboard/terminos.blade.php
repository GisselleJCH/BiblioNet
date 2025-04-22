@extends('layouts.estructura')

@section('titulo_pagina', 'Términos de Servicios')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Términos de Servicio</h2>
    <p class="text-muted">BiblioNet</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="fondo p-4">
                <p> Al registrarte y utilizar el sistema de la Biblioteca Aldo Díaz Lacayo, aceptas cumplir con nuestras normas:
                El uso de nuestra plataforma es exclusivamente para la gestión de préstamos y servicios bibliotecarios. Debes proporcionar 
                información veraz y mantener la confidencialidad de tu cuenta.
                </p>
                <hr>
                <p> Los libros y recursos deben ser utilizados de manera responsable y devueltos en los plazos indicados. 
                Nos reservamos el derecho de suspender cuentas que incumplan estas normas o realicen un uso indebido del sistema. 
                Estos términos pueden actualizarse sin previo aviso. Si continúas usando nuestros servicios después de una actualización, 
                aceptas los cambios realizados. </p>
                <hr>
                <p> Última actualización: 18/02/2025</p>
            </div>
        </div>
    </div>
</div>

@endsection
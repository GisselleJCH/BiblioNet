@extends('layouts.estructura')

@section('titulo_pagina', 'Políticas de Privacidad')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Políticas de Privacidad</h2>
    <p class="text-muted">BiblioNet</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="fondo p-4">
                <p> Tu privacidad es importante para nosotros. En Biblioteca Aldo Díaz Lacayo recopilamos y utilizamos 
                tu información personal únicamente para brindarte un mejor servicio. Los datos que solicitamos, como nombre, 
                correo electrónico se usan para gestionar tu cuenta y mejorar la experiencia en nuestra plataforma.
                No compartimos tu información con terceros sin tu consentimiento, salvo cuando lo exija la ley. </p>
                <hr>
                <p> Al utilizar nuestros servicios, aceptas nuestras prácticas de privacidad. </p>
                <hr>
                <p> Última actualización: 18/02/2025</p>
            </div>
        </div>
    </div>
</div>

@endsection
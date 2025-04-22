@extends('layouts.estructura')

@section('titulo_pagina', 'Ayuda')

@section('contenido')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold" style="color: #001C7D;">Ayuda</h2>
    <p class="text-muted">Preguntas Frecuentes</p>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="fondo p-4">
                <h4 class="fw-bold">¿Cómo puedo registrarme?</h4>
                <p>Para registrarte, dirígete a la sección de registro y completa el formulario con tus datos personales. Recuerda que el usuario debe ser tu inicial y tu apellido.</p>
                
                <h4 class="fw-bold">¿Cómo ingreso al sistema?</h4>
                <p>Para iniciar sesión en BiblioNet, ingresa tu usuario y contraseña en la página de inicio de sesión. Si no tienes una cuenta, primero debes registrarte.</p>

                <h4 class="fw-bold">¿Olvidé mi contraseña, qué debo hacer?</h4>
                <p>Si olvidaste tu contraseña, puedes restablecerla desde la página de inicio de sesión.</p>
                
                <h4 class="fw-bold">¿Cómo registro un estudiante o maestro en el sistema?</h4>
                <p>1. Ve a la sección Registros > Control Ingresos.</p>
                <p>2. Haz clic en la barra de búsqueda, escribe el carnet y si no aparece te dará la opcion de registrar uno nuevo. Y Si aparece solo seleccionalo para registrar el control de servicio.</p>
                <p>3. Completa los campos obligatorios y guarda la información.</p>
                <p>4. El estudiante o maestro estará registrado en el sistema y podrás gestionarlo desde la sección correspondiente.</p>

                <h4 class="fw-bold">¿Cómo registrar el ingreso de un estudiante a la biblioteca?</h4>
                <p>1. Ve a la sección Registros > Control Ingresos.</p>
                <p>2. Haz clic en la barra de búsqueda, escribe el carnet y si no aparece te dará la opcion de registrar uno nuevo. Y Si aparece solo seleccionalo para registrar el control de servicio.</p>
                <p>3. Completa los campos obligatorios y selecciona el tipo de servicio que utilizará.</p>
                <p>4. Ingresa la información adicional requerida (ejemplo: código de computadora si es préstamo de computadora).</p>
                <p>4. Guarda la información y el ingreso del estudiante quedará registrado en el sistema.</p>

                <h4 class="fw-bold">¿Cómo registrar un préstamo de material bibliográfico?</h4>
                <p>1. Selecciona o registra al miembro, luego en Control de Ingresos y Servicios, selecciona el tipo de servicio "Préstamo de Material Bibliográfico".</p>
                <p>2. Ingresa la signatura topográfica del libro.</p>
                <p>3. Completa los datos adicionales y guarda el préstamo.</p>

                <h4 class="fw-bold">¿Cómo registrar una devolución?</h4>
                <p>1. Accede a la sección "Devoluciones".</p>
                <p>2. Ingresa la información requerida, con el carnet y el tipo de préstamo que hizo aparecera ya sea el código de computadora o la signatura topográfica.</p>
                <p>3. Verifica los datos y confirma la devolución.</p>

                <h4 class="fw-bold">¿Cómo generar reportes?</h4>
                <p>1. Ve a la sección "Reportes".</p>
                <p>2. Selecciona el tipo de reporte que deseas generar (ejemplo: reportes de biblioteca o CNU).</p>
                <p>3. Filtra por fechas y genera el reporte.</p>

                <h4 class="fw-bold">¿Puedo editar o eliminar un registro de ingreso o préstamo?</h4>
                <p>Sí, puedes editar los registros accediendo a la sección correspondiente y seleccionando la opción de edición/eliminación.</p>

            </div>
        </div>
    </div>
</div>

@endsection
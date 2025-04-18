@extends('layouts/main')
@section('titulo_pagina', 'BiblioNet | Registro de usuario')

@section('contenido')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="d-flex justify-content-center align-items-center vh-100" 
     style="background-image: url('/img/fondo_bibliotecaa.jpg'); background-size: cover; background-position: center; position: relative;">
    
    <!-- Capa negra transparente -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.5);"></div>

    <div class="position-relative" style="width: 24rem; z-index: 1;">
        <!-- Logo flotante (se le agrega z-index: 2 para que esté por encima) -->
        <div class="position-absolute top-0 start-50 translate-middle rounded-circle shadow-lg" 
             style="width: 110px; height: 110px; display: flex; align-items: center; justify-content: center; background-color: #001C7D; z-index: 2;">
            <img src="{{ asset('/img/LogoBlanco.png') }}" alt="Logo" style="width: 80px;">
        </div>

        <!-- Tarjeta de Registro -->
        <div class="card p-5 shadow text-white text-center" 
             style="border-radius: 15px; background-color: #001C7D; padding-top: 5rem; position: relative; z-index: 1;">
            
            <!-- Título -->
            <h2 class="mb-4 fw-bold" style="display: inline-block; padding-bottom: 15px; margin-top: 20px;">
                Registro
            </h2>

            <form action="{{ route('registrar') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-user text-dark"></i>
                        </span>
                        <input type="text" class="form-control rounded-end" name="name" id="name" placeholder="Nombre Completo">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-envelope text-dark"></i>
                        </span>
                        <input type="email" class="form-control rounded-end" name="email" id="email" placeholder="Correo Electrónico">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-user text-dark"></i>
                        </span>
                        <input type="text" class="form-control rounded-end" name="user" id="user" placeholder="Usuario">
                    </div>
                </div>

              <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-lock text-dark"></i>
                        </span>
                        <input type="password" class="form-control rounded-end" name="password" id="password" placeholder="Contraseña">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const passwordInput = document.getElementById('password');
                        const togglePassword = document.getElementById('togglePassword');
                        const toggleIcon = togglePassword.querySelector('i');

                        togglePassword.addEventListener('click', function() {
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                                toggleIcon.classList.remove('fa-eye');
                                toggleIcon.classList.add('fa-eye-slash');
                            } else {
                                passwordInput.type = 'password';
                                toggleIcon.classList.remove('fa-eye-slash');
                                toggleIcon.classList.add('fa-eye');
                            }
                        });
                    });
                </script>

                <button class="btn btn-light w-50 mt-3" style="color: #001C7D; font-weight: bold; border-radius: 10px;">
                    Registrarse
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" style="color: #ffffff; text-decoration: underline;">¿Ya tienes cuenta? Inicia Sesión</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection


@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let errorMessages = `
            <ul style='text-align: left;'>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `;

        Swal.fire({
            title: 'Error en el Registro',
            html: errorMessages,
            icon: 'error',
            confirmButtonText: 'Aceptar',
            allowOutsideClick: false
        });
    });
</script>
@endif

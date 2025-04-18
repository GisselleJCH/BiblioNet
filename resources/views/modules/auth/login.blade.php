@extends('layouts/main')

@section('titulo_pagina', 'BiblioNet | Login')

@section('contenido')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="d-flex justify-content-center align-items-center vh-100" 
     style="background-image: url('/img/fondo_bibliotecaa.jpg'); background-size: cover; background-position: center;">
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background-color: rgba(0, 0, 0, 0.5); z-index: 1;">
    </div>
    
    <div class="position-relative" style="width: 24rem;">
        <div class="position-absolute top-0 start-50 translate-middle rounded-circle shadow-lg" 
             style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; background-color: #001C7D; z-index: 10;">
            <img src="{{ asset('/img/LogoBlanco.png') }}" alt="Logo" style="width: 80px;">
        </div>

        <!-- Tarjeta de Login -->
        <div class="card p-5 shadow text-white text-center position-relative" 
             style="border-radius: 15px; background-color: #001C7D; padding-top: 5rem; z-index: 5;">
            
            <h2 class="mb-4 fw-bold" style="display: inline-block; padding-bottom: 15px; margin-top: 20px;">
                Iniciar Sesión
            </h2>

            <form action="{{ route('logear') }}" method="POST">
                @csrf
                @method('POST')
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
                    Ingresar
                </button>
                <div class="text-center mt-3">
                    <a href="{{ route('registro') }}" style="color: #ffffff; text-decoration: underline;">¿No tienes cuenta? Regístrate</a>
                </div>
                <div class="text-center mt-2">
                    <a href="{{ route('password.request') }}" style="color: #ffffff; text-decoration: underline;">¿Olvidaste tu contraseña?</a>
                </div>
            </form>
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
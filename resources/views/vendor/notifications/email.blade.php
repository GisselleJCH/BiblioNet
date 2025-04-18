@component('mail::message')
# Hola

Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.

@component('mail::button', ['url' => $actionUrl])
Restablecer Contraseña
@endcomponent

Este enlace para restablecer la contraseña expirará en {{ config('auth.passwords.users.expire') }} minutos.

Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.

Saludos,<br>
{{ config('app.name') }}

@slot('subcopy')
Si tienes problemas para hacer clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu navegador: [{{ $actionUrl }}]({{ $actionUrl }})
@endslot
@endcomponent
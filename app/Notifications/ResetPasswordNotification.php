<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('password.reset', 
        ['token' => $this->token, 
        'email' => $notifiable->getEmailForPasswordReset()]);

        return (new MailMessage)
            ->subject('Restablecer Contraseña')
            ->line('Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.')
            ->action('Restablecer Contraseña', $url)
            ->line('Este enlace para restablecer la contraseña expirará en ' . config('auth.passwords.users.expire') . ' minutos.')
            ->line('Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.');
    }
}
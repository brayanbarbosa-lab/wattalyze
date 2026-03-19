<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Solicitação de Redefinição de Senha')
            ->line('Você está recebendo este email porque recebemos uma solicitação de redefinição de senha')
            ->action('Redefinir Senha', url(route('password.reset', $this->token, false)))
            ->line('Este link de redefinição de senha expirará em 60 minutos.')
            ->line('Se você não solicitou uma redefinição de senha, nenhuma ação adicional deverá ser feita');
    }
}

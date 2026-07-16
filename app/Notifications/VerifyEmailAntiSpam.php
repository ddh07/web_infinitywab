<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailAntiSpam extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Confirmez votre adresse email - Infinity WAB')
            ->greeting('Bonjour '.($notifiable->name ?? ''))
            ->line('Votre compte d\'administration Infinity WAB a ete cree avec succes.')
            ->line('Pour activer votre compte, confirmez votre adresse email en cliquant sur le bouton ci-dessous.')
            ->action('Confirmer mon email', $verificationUrl)
            ->line('Ce lien de verification expire automatiquement pour des raisons de securite.')
            ->line('Si vous n etes pas a l origine de cette inscription, ignorez simplement ce message.')
            ->salutation('Equipe Infinity WAB');
    }
}

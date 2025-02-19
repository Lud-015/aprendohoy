<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $actionText = 'Verificar Correo Electrónico';
        $actionUrl = url('/verify-email/' . $notifiable->getKey() . '/' . sha1($notifiable->getEmailForVerification()));
        $esVerificacion = Str::contains($actionText, 'Verificar');

        return (new MailMessage)
            ->subject('Verifica tu correo electrónico')
            ->view('vendor.notifications.email', [
                'actionText' => $actionText,
                'actionUrl' => $actionUrl,
                'esVerificacion' => $esVerificacion,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
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
        return (new MailMessage)
                    ->subject('Şifre Sıfırlama Talebi')
                    ->line('Merhaba!')
                    ->line('Hesabınız için şifre sıfırlama talebi aldık.')
                    ->action('Şifre Sıfırlama', url('password/reset', $this->token))
                    ->line('Bu şifre sıfırlama bağlantısı 60 dakika içinde sürecektir.')
                    ->line('Eğer bu talebi siz yapmadıysanız, herhangi bir işlem yapmanıza gerek yoktur.')
                    ->line('Saygılarımızla,')
                    ->line('Emlak Sepette');
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

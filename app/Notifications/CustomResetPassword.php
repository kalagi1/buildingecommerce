<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordNotification
{
    /**
     * Get the notification's mail representation.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('auth.reset_password_subject'))
                    ->line(__('auth.reset_password_intro'))
                    ->line(__('auth.reset_password_line1'))
                    ->action(__('auth.reset_password_action'), url('password/reset', $this->token))
                    ->line(__('auth.reset_password_expiry'))
                    ->line(__('auth.reset_password_footer'))
                    ->line(__('auth.reset_password_signoff'))
                    ->line(__('auth.reset_password_sender'))
                    ->line(__('auth.reset_password_url', ['url' => url('password/reset', $this->token)]));

    }
}

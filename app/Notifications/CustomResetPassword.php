<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    protected $token;

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
        $resetUrl = url('password/reset', $this->token);

        return (new MailMessage)
            ->subject(__('auth.reset_password_subject'))
            ->view('emails.password_reset', [
                'subject' => __('auth.reset_password_subject'),
                'content' => __('auth.reset_password_intro') . '<br><br>'
                            . __('auth.reset_password_line1') . '<br><br>'
                            . '<a href="' . $resetUrl . '" style="font-size: 16px; font-weight: bold; color: #1d72b8; text-decoration: none;">' 
                            . __('auth.reset_password_action') . '</a><br><br>'
                            . __('auth.reset_password_expiry') . '<br><br>'
                            . __('auth.reset_password_footer'),
            ]);
    }
}

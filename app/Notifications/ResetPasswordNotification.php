<?php

namespace app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    private string $token;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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
    public function toMail(object $notifiable): MailMessage
{
    $url =
        env('FRONTEND_URL')
        .
        "/reset-password?token="
        .
        $this->token
        .
        "&email="
        .
        urlencode($notifiable->email);

    return (new MailMessage)

        ->subject('Reset Your Password')

        ->greeting('Hello '.$notifiable->name)

        ->line('We received a request to reset your password.')

        ->action(
            'Reset Password',
            $url
        )

        ->line('This link expires in 60 minutes.')

        ->line('If you did not request this email, no further action is required.')

        ->salutation('Inventory ERP Team');
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
              'title' => 'Reset Password',

              'email' => $notifiable->email,
        ];
    }
}

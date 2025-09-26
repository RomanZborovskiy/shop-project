<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserRegisteredNotification extends Notification
{
    use Queueable;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Новий користувач зареєструвався')
            ->greeting('Привіт, адміністраторе!')
            ->line('Новий користувач зареєструвався на сайті.')
            ->line('Ім’я: ' . $this->user->name)
            ->line('Email: ' . $this->user->email);
    }
}

<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Нове замовлення #' . $this->order->id)
            ->line('Було підтверджено нове замовлення.')
            ->line('Номер замовлення: ' . $this->order->id)
            ->line('Сума: ' . $this->order->total . ' грн');
    }
}

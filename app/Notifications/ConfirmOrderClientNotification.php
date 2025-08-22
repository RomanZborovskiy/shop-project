<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\TurboSms\TurboSmsChannel;
use NotificationChannels\TurboSms\TurboSmsMessage;

class ConfirmOrderClientNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
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
        return [TurboSmsChannel::class, MailChannel::class];;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Підтвердження замовлення #' . $this->order->id)
            ->greeting('Вітаємо, ' . $notifiable->name . '!')
            ->line('Ваше замовлення було підтверджено.')
            ->line('Номер замовлення: ' . $this->order->id)
            ->line('Сума: ' . $this->order->total_price . ' грн')
            ->line('Дякуємо, що обрали наш магазин!');
    }

    public function toTurboSMS($notifiable): TurboSMSMessage
    {
        \Log::info("Відправка SMS на номер: {$notifiable->phone} для замовлення #{$this->order->id}");
        return (new TurboSmsMessage())
            ->content("Ваше замовлення #{$this->order->id} підтверджено.")
            ->test(config('services.turbosms.sandboxMode', true)); 
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

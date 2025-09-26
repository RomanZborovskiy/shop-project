<?php

namespace App\Listeners;

use App\Events\ConfirmOrder;
use App\Notifications\ConfirmOrderClientNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConfirmOrderClient implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ConfirmOrder $event): void
    {
        $client = $event->order->user;
        $client->notify(new ConfirmOrderClientNotification($event->order));
    }
}

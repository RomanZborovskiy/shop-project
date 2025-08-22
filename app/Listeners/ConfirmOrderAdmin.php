<?php

namespace App\Listeners;

use App\Events\ConfirmOrder;
use App\Mail\NewOrderAdminMail;
use App\Models\User;
use App\Notifications\ConfirmOrderClientNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ConfirmOrderAdmin
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

        $order = $event->order;
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new NewOrderAdminMail($order));
        }
    }
}

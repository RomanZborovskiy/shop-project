<?php

namespace App\Listeners;

use App\Notifications\NewUserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminsAboutNewUser
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
    public function handle(Registered $event): void
    {
        $emails = User::role('admin')
            ->pluck('email')  
            ->filter()
            ->unique();

        if ($emails->isNotEmpty()) {
            Notification::route('mail', $emails->toArray())
                ->notify(new NewUserRegisteredNotification($event->user));
        }
    }
}

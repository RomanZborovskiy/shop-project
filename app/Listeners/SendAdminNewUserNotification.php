<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Mail\NewUserRegisteredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendAdminNewUserNotification
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
        $newUser = $event->user;

        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new NewUserRegisteredMail($newUser));
        }
    }
}

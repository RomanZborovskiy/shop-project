<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\Mailing;
use App\Notifications\LeadMessageNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class SendLeadMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Mailing $mailing) {}

    public function handle(): void
    {
         $emails = Lead::query()
            ->whereNotNull('fields->email')
            ->distinct()
            ->pluck('fields->email');

        if ($emails->isNotEmpty()) {
            Notification::route('mail', $emails->toArray())
                ->notify(new LeadMessageNotification(
                    subjectText: $this->mailing->subject,
                    bodyText: $this->mailing->body
                ));
        }

        $this->mailing->update(['status' => 'done']);
    }
}

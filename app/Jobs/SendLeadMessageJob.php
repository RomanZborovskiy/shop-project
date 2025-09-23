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

    // public function handle(): void
    // {
    //     Lead::orderBy('id')->chunkById(1000, function ($leads) {
    //         foreach ($leads as $lead) {
    //             $email = $lead->fields['email'] ?? null;
    //             if ($email) {
    //                 Mail::to($email)->send(
    //                     new LeadMessageMail($this->mailing->subject, $this->mailing->body)
    //                 );
    //             }
    //         }
    //     });

    //     $this->mailing->update(['status' => 'done']);
    // }
    public function handle(): void
    {
        $emails = Lead::all()
            ->map(fn($lead) => $lead->fields['email'] ?? null)
            ->filter()
            ->unique()
            ->values();

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

<?php

namespace App\Jobs;

use App\Mail\LeadMessageMail;
use App\Models\Lead;
use App\Models\LeadMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
class SendLeadMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public LeadMessage $mailing) {}

    public function handle(): void
    {
        Lead::orderBy('id')->chunkById(1000, function ($leads) {
            foreach ($leads as $lead) {
                $email = $lead->fields['email'] ?? null;
                if ($email) {
                    Mail::to($email)->send(
                        new LeadMessageMail($this->mailing->subject, $this->mailing->body)
                    );
                }
            }
        });

        $this->mailing->update(['status' => 'done']);
    }
}

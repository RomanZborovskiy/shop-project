<?php

namespace App\Actions\Schedule;

use App\Jobs\SendLeadMessageJob;
use App\Models\Mailing;
use Illuminate\Support\Facades\Log;

class MailingAction
{
    public function execute(): void
    {
        $mailings = Mailing::where('scheduled_at', '<=', now())
            ->where('status', 'pending')
            ->get();

        foreach ($mailings as $mailing) {
            Log::info("Запускаю розсилку #{$mailing->id}");
            $mailing->update(['status' => 'processing']);
            dispatch(new SendLeadMessageJob($mailing));
        }

        Log::info('ProcessLeadMessagesAction виконалась о ' . now());
    }
}

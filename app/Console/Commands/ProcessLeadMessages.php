<?php

namespace App\Console\Commands;

use App\Jobs\SendLeadMessageJob;
use App\Models\LeadMessage;
use Illuminate\Console\Command;

class ProcessLeadMessages extends Command
{
    protected $signature = 'sendemail:process';

    protected $description = 'Запускає всі розсилки, час яких настав';


    public function handle(): int
    {
        $mailings = LeadMessage::where('scheduled_at', '<=', now())
            ->where('status', 'pending')->get();

        foreach ($mailings as $mailing) {
            $this->info("Запускаю розсилку #{$mailing->id}");

            $mailing->update(['status' => 'processing']);

            dispatch(new SendLeadMessageJob($mailing));
        }

        return self::SUCCESS;
    }
}

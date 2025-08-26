<?php

use App\Jobs\CacheDashboardStatsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Actions\Schedule\MailingAction;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    app(MailingAction::class)->execute();
})->everyMinute();

Schedule::job(new CacheDashboardStatsJob())->hourly();

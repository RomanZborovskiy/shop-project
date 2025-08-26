<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class CacheDashboardStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::forget('dashboard_stats');

        Cache::remember('dashboard_stats', now()->addMinutes(60), function () {
            return [
                'productsCount' => Product::count(),
                'ordersCount'  => Order::count(),
                'leadsCount' => Lead::count(),
                'clientsCount' => User::role('user')->count(),
            ];
        });
    }
}

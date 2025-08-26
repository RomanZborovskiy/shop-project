<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;


class DashboardController extends Controller
{   
    public function index()
    {
        $stats = Cache::get('dashboard_stats', [
            'productsCount' => 0,
            'ordersCount' => 0,
            'leadsCount' => 0,
            'clientsCount'  => 0,
        ]);

        $latestOrders = Order::with('user')->latest()->take(20)->get();

        return view('admin.dashboard.index', compact('stats','latestOrders'));
    }
}

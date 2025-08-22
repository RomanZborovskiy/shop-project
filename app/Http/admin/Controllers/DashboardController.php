<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Spatie\Permission\Models\Role;


class DashboardController extends Controller
{   
    public function index()
    {
        $products = Product::count();
        $orders = Order::count();
        $leads = Lead::count();
        $users = User::role('user')->count();

        return view('admin.dashboard.index', compact('products','orders', 'leads' ,'users'));
    }
}

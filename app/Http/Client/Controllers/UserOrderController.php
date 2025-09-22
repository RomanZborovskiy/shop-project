<?php

namespace App\Http\Client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
   public function index()
    {
        $orders = Auth::user()->orders()->with('purchases.product')->latest()->paginate(10);

        return view('client.profile.my_orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Доступ заборонено');
        }

        $order->load('purchases.product', 'user');

        return view('client.profile.my_one_order', compact('order'));
    }   
}

<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('purchases.product')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Доступ заборонено',
            ], 403);
        }

        $order->load('purchases.product', 'user');

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }
}

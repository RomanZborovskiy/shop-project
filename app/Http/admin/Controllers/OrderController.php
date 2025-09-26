<?php

namespace App\Http\admin\Controllers;

use App\Events\ConfirmOrder;
use App\Http\admin\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('purchases.product', 'user')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }


    public function edit(Order $order)
    {
        $order->load('purchases');
        $products = Product::all();
        return view('admin.orders.edit', compact('order', 'products'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $order->update([
            'status' => $data['status'],
            'type' => $data['type'] ?? null,
            'user_info' => $data['user_info'] ?? null,
            'total_price' => collect($data['purchases'])->sum(fn($p) => $p['price'] * $p['quantity']),
        ]);

        $order->purchases()->delete();
        foreach ($data['purchases'] as $purchase) {
            $order->purchases()->create($purchase);
        }

        ConfirmOrder::dispatch($order);

        return redirect()->back()->with('success', 'Замовлення оновлено');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Замовлення видалено');
    }
}

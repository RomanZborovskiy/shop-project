<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
     public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating'    => 'integer',
            'comment'   => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:reviews,id',
        ]);

        $validated['status']     = 'pending';
        $validated['user_id']    = Auth::id();
        $validated['product_id'] = $product->id;

        Review::create($validated);

        return redirect()->route('client.shop.show', $product)->with('success', 'Відгук додано!');
    }
}
   
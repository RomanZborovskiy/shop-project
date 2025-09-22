<?php

namespace App\Http\Client\Controllers;

use App\Http\Client\Requests\ReviewRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
     public function store(ReviewRequest $request, Product $product)
    {
        $validated = $request->validated();

        $validated['status'] = 'pending';
        $validated['user_id'] = Auth::id();
        $validated['product_id'] = $product->id;

        Review::create($validated);

        return redirect()->route('client.shop.show', $product)->with('success', 'Відгук додано!');
    }
}
   
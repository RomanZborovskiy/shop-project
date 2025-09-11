<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Requests\ReviewRequest;
use App\Http\Client\Api\Resources\CategoryResource;
use App\Http\Client\Api\Resources\PageResource;
use App\Http\Client\Api\Resources\ReviewResource;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        $reviews = $product->reviews()->get();

        return ReviewResource::collection($reviews);
    }

    public function store(ReviewRequest $request, Product $product)
    {
        $validated = $request->validated();

        $review = Review::create([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'parent_id' => $validated['parent_id'],
            'status' => 'pending',
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return ReviewResource::make($review);
    }
}

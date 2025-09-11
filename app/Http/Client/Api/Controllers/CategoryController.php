<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Term;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Term::all();
        return CategoryResource::collection($categories);
    }

    public function show(string $slug)
    {
        $category = Term::where('slug', $slug)->firstOrFail();
        return CategoryResource::make($category);
    }
}

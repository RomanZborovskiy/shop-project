<?php

namespace App\Http\Client\Api\Controllers;

use App\Http\Client\Api\Resources\PageResource;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $template)
    {
        $page = Page::where('template', $template)->firstOrFail();
        return PageResource::make($page);
    }
}

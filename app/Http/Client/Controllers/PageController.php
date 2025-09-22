<?php

namespace App\Http\Client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show($template)
    {
        $page = Page::where('template', $template)->firstOrFail();

        $view = "client.pages.{$page->template}";

        if (!view()->exists($view)) {
            $view = "client.pages.default";
        }

        return view($view, compact('page'));
    }
}
   
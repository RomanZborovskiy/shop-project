<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateSitemapJob;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.profile.settings');
    }
    
    public function generateSitemap()
    {
        GenerateSitemapJob::dispatch();

        return back()->with('success', 'Генерація карти сайту запущена у фоні.');
    }
}
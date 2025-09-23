<?php

namespace App\Http\admin\Controllers;

use App\Actions\GenerateSitemapAction;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.profile.settings');
    }
    
    public function generateSitemap()
    {
        GenerateSitemapAction::run();

        return back()->with('success', 'Генерація карти сайту запущена у фоні.');
    }
}
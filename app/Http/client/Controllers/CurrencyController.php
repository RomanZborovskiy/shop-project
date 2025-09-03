<?php

namespace App\Http\client\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function change(Request $request)
    {
        $currency = $request->input('currency');

        if (in_array($currency, config('currency.available'))) {
            session(['currency' => $currency]);
        }

        return back(); 
    }
}
   
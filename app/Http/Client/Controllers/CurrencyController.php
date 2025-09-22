<?php

namespace App\Http\Client\Controllers;

use App\Http\Controllers\Controller;
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
   
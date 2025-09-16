<?php

namespace App\Facades;

use App\Services\FavoriteService;
use Illuminate\Support\Facades\Facade;

class Favorite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'favorite';
    }
}
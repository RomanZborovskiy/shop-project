<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function toggle(Model $model): bool
    {
        $userId = Auth::id();

        $favorite = Favorite::where([
            'model_id'   => $model->id,
            'model_type' => get_class($model),
            'user_id'    => $userId,
        ])->first();

        if ($favorite) {
            $favorite->delete();
            return false; 
        }

        Favorite::create([
            'model_id'   => $model->id,
            'model_type' => get_class($model),
            'user_id'    => $userId,
        ]);

        return true; 
    }

    public function isFavorite(Model $model): bool
    {
        return Favorite::where([
            'model_id'   => $model->id,
            'model_type' => get_class($model),
            'user_id'    => Auth::id(),
        ])->exists();
    }
}
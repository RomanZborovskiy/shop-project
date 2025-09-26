<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    protected array $favoritesCache = [];
    protected bool $loaded = false;

    public function toggle(Model $model): bool
    {
        $userId = Auth::id();

        $favorite = Favorite::where([
            'model_id'   => $model->id,
            'model_type' => $model->getMorphClass(),
            'user_id'    => $userId,
        ])->first();

        if ($favorite) {
            $favorite->delete();
            return false; 
        }

        Favorite::create([
            'model_id'   => $model->id,
            'model_type' => $model->getMorphClass(),
            'user_id'    => $userId,
        ]);

        return true; 
    }

    protected function loadFavorites(): void
    {
        if ($this->loaded || !Auth::check()) {
            return;
        }

        $favorites = Favorite::where('user_id', Auth::id())->get();

        foreach ($favorites as $fav) {
            $this->favoritesCache[$fav->model_type][] = $fav->model_id;
        }

        $this->loaded = true;
    }

    public function isFavorite(Model $model): bool
    {
        $this->loadFavorites();

        $type = $model->getMorphClass();
        return in_array($model->id, $this->favoritesCache[$type] ?? []);
    }
}
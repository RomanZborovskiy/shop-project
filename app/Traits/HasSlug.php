<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlug();
        });
    }

    public function generateSlug()
    {
        if (!empty($this->name)) {
            $baseSlug = Str::slug($this->name);
            $slug = $baseSlug;
            $i = 1;

            while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            $this->slug = $slug;
        }
    }
}

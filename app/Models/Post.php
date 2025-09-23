<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use Fomvasss\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Fomvasss\Seo\Models\HasSeo;

class Post extends Model
{
    use HasFactory, HasSlug, HasSeo;
    
    protected $guarded = [
        'id',
    ];

    public function category()
    {
        return $this->belongsTo(Term::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'model');
    }
}

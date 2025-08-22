<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, HasSlug;
    
    protected $guarded = [
        'id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

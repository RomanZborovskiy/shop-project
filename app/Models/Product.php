<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'quantity',
        'sku',
        'slug',
        'brand_id',
        'category_id',
    ];

    // Зв'язки
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function properyable()
    {
        return $this->belongsToMany(Propertyable::class);
    }

    public function rewiews()
    {
        return $this->belongsTo(Review::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}

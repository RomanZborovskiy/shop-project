<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propertyable extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

}




<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}

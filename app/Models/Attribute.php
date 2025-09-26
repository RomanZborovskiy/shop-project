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
    public function categories()
    {
        return $this->belongsToMany(Term::class, 'category_attributes', 'attribute_id', 'category_id');
    }

}

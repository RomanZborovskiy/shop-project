<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function propertyables()
    {
        return $this->hasMany(Propertyable::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'propertyables');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'value',
        'attribute_id',
    ];

    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function propertyables()
    {
        return $this->hasMany(Propertyable::class);
    }
}

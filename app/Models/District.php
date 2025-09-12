<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [
        'id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}

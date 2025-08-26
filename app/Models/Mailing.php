<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'filters' => 'array',
        'scheduled_at' => 'datetime',
    ];
    
    protected $attributes = [
        'status' => 'pending',
    ];
}

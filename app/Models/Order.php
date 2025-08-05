<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_price',
        'status',
        'type',
        'user_info',
        'payment_id',
        'user_id',
    ];

    protected $casts = [
        'user_info' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function payment()
    // {
    //     return $this->belongsTo(Payment::class);
    // }
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}

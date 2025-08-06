<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    const BASKER_TYPE = 'basket';
    const ORDER_TYPE =  'order';

    protected $guarded = [
        'id',
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

    public static function statusesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::BASKER_TYPE,
                'name' => trans('lists.basket_type.' . self::BASKER_TYPE . '.name'),
            ],
            [
                'key' => self::ORDER_TYPE,
                'name' => trans('lists.basket_type.' . self::ORDER_TYPE . '.name'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }
}

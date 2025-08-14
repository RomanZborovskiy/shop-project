<?php

namespace App\Models;

use App\Models\Traits\HasStaticLists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, HasStaticLists;

    const BASKER_STATUS = 'basket';
    const ORDER_STATUS =  'order';
    const TYPE_CASH =  'cash';
    const TYPE_CARD =  'card';

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
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public static function statusesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::BASKER_STATUS,
                //'name' => trans('lists.basket_type.' . self::BASKER_TYPE . '.name'),
                'name'=>'Корзина'
            ],
            [
                'key' => self::ORDER_STATUS,
                //'name' => trans('lists.basket_type.' . self::ORDER_TYPE . '.name'),
                'name'=>'Замовлення'
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }

    public static function typeList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::TYPE_CASH,
                //'name' => trans('lists.basket_type.' . self::BASKER_TYPE . '.name'),
                'name'=>'Готівкою'
            ],
            [
                'key' => self::TYPE_CARD,
                //'name' => trans('lists.basket_type.' . self::ORDER_TYPE . '.name'),
                'name'=>'Картою'
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }
}

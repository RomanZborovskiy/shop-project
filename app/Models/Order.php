<?php

namespace App\Models;

use App\Models\Traits\HasStaticLists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, HasStaticLists;

    const STATUS_PROCESSING = 'processing';
    const STATUS_PENDING =  'pending';
    const NEW_STATUS = 'new';
    const TYPE_CART =  'cart';
    const TYPE_ORDER =  'order';

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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function recalculateTotalPrice()
    {
        $total = $this->purchases->reduce(function ($carry, $purchase) {
            return $carry + ($purchase->price * $purchase->quantity);
        }, 0);

        $this->total_price = $total;
        $this->save();
    }

    public static function statusesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::STATUS_PROCESSING,
                //'name' => trans('lists.basket_type.' . self::BASKER_TYPE . '.name'),
                'name'=>'Обробляєьбся'
            ],
            [
                'key' => self::STATUS_PENDING,
                //'name' => trans('lists.basket_type.' . self::ORDER_TYPE . '.name'),
                'name'=>'Очікує підтвердження'
            ],
            [
                'key' => self::NEW_STATUS,
                //'name' => trans('lists.basket_type.' . self::ORDER_TYPE . '.name'),
                'name'=>'Нове замовлення'
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }

    public static function typeList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::TYPE_ORDER,
                //'name' => trans('lists.basket_type.' . self::BASKER_TYPE . '.name'),
                'name'=>'Замовлення'
            ],
            [
                'key' => self::NEW_STATUS,
                //'name' => trans('lists.basket_type.' . self::ORDER_TYPE . '.name'),
                'name'=>'Корзина'
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }
}

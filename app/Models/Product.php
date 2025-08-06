<?php

namespace App\Models;

use App\Models\Traits\HasStaticLists;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasStaticLists;

    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'status' => self::STATUS_PENDING,
        'name', 'description', 'price', 'old_price',
        'quantity', 'brand_id', 'category_id', 'status',
        'sku', 'slug',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function properyable()
    {
        return $this->belongsToMany(Propertyable::class);
    }

    public function rewiews()
    {
        return $this->belongsTo(Review::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * @param string|null $columnKey
     * @param string|null $indexKey
     * @return array
     */
    public static function statusesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::STATUS_PENDING,
                // 'name' => trans('lists.product_statuses.' . self::STATUS_PENDING . '.name'),
                'name'=>'Очікує'
            ],
            [
                'key' => self::STATUS_PUBLISHED,
                // 'name' => trans('lists.product_statuses.' . self::STATUS_PUBLISHED . '.name'),
                'name'=>'Опубліковано'
            ]
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }

}

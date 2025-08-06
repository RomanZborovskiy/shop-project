<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    const STATUS_PENDDING = 'pendding';
    const STATUS_REJECTED = 'rejected';


    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

    public static function statusesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::STATUS_PENDDING,
                'name' => trans('lists. review_statuses.' . self::STATUS_PENDDING . '.name'),
            ],
            [
                'key' => self::STATUS_REJECTED,
                'name' => trans('lists.review_statuses.' . self::STATUS_REJECTED . '.name'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }
}

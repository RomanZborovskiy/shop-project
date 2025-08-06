<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    const ARTICLE_TYPE = 'article';
    const PRODUCT_TYPE = 'product';
    
    protected $guarded = [
        'id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function typesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::ARTICLE_TYPE,
                'name' => trans('lists.category_type.' . self::ARTICLE_TYPE . '.name'),
            ],
            [
                'key' => self::PRODUCT_TYPE,
                'name' => trans('lists.category_type.' . self::PRODUCT_TYPE . '.name'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }

}

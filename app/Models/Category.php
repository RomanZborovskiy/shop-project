<?php

namespace App\Models;

use App\Models\Traits\HasStaticLists;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;


class Category extends Model
{
    use HasFactory, HasStaticLists, HasSlug, NodeTrait;

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
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function typesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::ARTICLE_TYPE,
                //'name' => trans('lists.category_type.' . self::ARTICLE_TYPE . '.name'),
                'name'=>'article',
            ],
            [
                'key' => self::PRODUCT_TYPE,
                //'name' => trans('lists.category_type.' . self::PRODUCT_TYPE . '.name'),
                'name'=>'product'
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }

}

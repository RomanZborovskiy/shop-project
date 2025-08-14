<?php

namespace App\Models;

use App\Traits\HasSlug;

class Term extends \Fomvasss\SimpleTaxonomy\Models\Term
{
    use HasSlug;
    // NEXT RELATIONS, METHODS IS EXAMPLES, YOU CAN DELETE IT:

    const VOCABULARY_TAGS = 'tags';
    const VOCABULARY_CATEGORIES = 'categories';

    protected $attributes = [
        'weight' => 10000,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function productsByTag()
    {
        return $this->morphedByMany(Article::class, 'termable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public static function vocabulariesList(string $columnKey = null, string $indexKey = null): array
    {
        $records = [
            [
                'slug' => 'categories',
                'name' => 'Categories',
                'has_nested' => true,
            ],
            [
                'slug' => 'tags',
                'name' => 'Tags',
                'has_nested' => false,
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey);
    }
}

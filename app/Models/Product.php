<?php

namespace App\Models;

use App\Models\Traits\HasStaticLists;
use App\Models\Traits\HasSlug;
use Fomvasss\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Fomvasss\MediaLibraryExtension\HasMedia\HasMedia;
use Fomvasss\MediaLibraryExtension\HasMedia\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;
use Fomvasss\Seo\Models\HasSeo;

class Product extends Model implements HasMedia
{
    use HasFactory, HasStaticLists, HasSlug, InteractsWithMedia, HasSeo;

    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';

    protected $guarded = [
        'id',
    ];

    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    protected $mediaMultipleCollections = ['images'];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Term::class, 'category_id');
    }

    public function propertyable()
    {
        return $this->belongsToMany(Propertyable::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'propertyables');
    }

    public function registerMediaCollections(): void
    {       
        $this->addMediaCollection('product_gallery')
            ->useDisk('public');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'model');
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
    // фільтрування та пощук
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['price_from'])) {
            $query->where('price', '>=', (float) $filters['price_from']);
        }
        if (!empty($filters['price_to'])) {
            $query->where('price', '<=', (float) $filters['price_to']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }

        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', (int) $filters['brand_id']);
        }

        if (isset($filters['has_images'])) {
            if ($filters['has_images'] === '1') {
                $query->whereHas('media', fn (Builder $q) => $q->where('collection_name', 'images'));
            } elseif ($filters['has_images'] === '0') {
                $query->whereDoesntHave('media', fn (Builder $q) => $q->where('collection_name', 'images'));
            }
        }

        if (!empty($filters['sort_by']) && in_array($filters['sort_by'], ['name', 'price', 'sku'])) {
            $direction = $filters['direction'] ?? 'asc';
            $query->orderBy($filters['sort_by'], $direction);
        }

        return $query;
    }
}

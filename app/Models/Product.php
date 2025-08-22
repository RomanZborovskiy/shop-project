<?php

namespace App\Models;

use App\Models\Traits\HasStaticLists;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\Models\Media;
use Fomvasss\MediaLibraryExtension\HasMedia\HasMedia;
use Fomvasss\MediaLibraryExtension\HasMedia\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, HasStaticLists, HasSlug, InteractsWithMedia;

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
        return $this->belongsTo(Category::class);
    }

    public function propertyable()
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

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'propertyables');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {       
        $this->addMediaCollection('product_gallery')
            ->useDisk('public');
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

    public function scopeFilterName($query, $name)
    {
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }
    }
     // 💰 Фільтр по ціні (від-до)
    public function scopeFilterPrice($query, $from, $to)
    {
        if (!empty($from)) {
            $query->where('price', '>=', $from);
        }
        if (!empty($to)) {
            $query->where('price', '<=', $to);
        }
    }

    // фільтрування та пощук
    public function scopeFilterCategory($query, $categoryId)
    {
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }
    }

    public function scopeFilterHasImages($query, $hasImages)
    {
        if ($hasImages === '1') {
            $query->whereHas('media', fn($q) => $q->where('collection_name', 'images'));
        } elseif ($hasImages === '0') {
            $query->whereDoesntHave('media', fn($q) => $q->where('collection_name', 'images'));
        }
    }

    public function scopeSortBy($query, $sortBy, $direction = 'asc')
    {
        if (in_array($sortBy, ['name', 'price', 'sku'])) {
            $query->orderBy($sortBy, $direction);
        }
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->filterName($request->name ?? null)
            ->filterPrice($request->price_from ?? null, $request->price_to ?? null)
            ->filterCategory($request->category_id ?? null)
            ->filterHasImages($request->has_images ?? null)
            ->sortBy($request->sort_by ?? null, $request->direction ?? 'asc');
    }
}

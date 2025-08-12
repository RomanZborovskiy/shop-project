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

    protected $mediaSingleCollections = ['']; 
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

}

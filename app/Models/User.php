<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\HasStaticLists;
use Spatie\Image\Enums\Fit;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\Models\Media;
use Fomvasss\MediaLibraryExtension\HasMedia\HasMedia;
use Fomvasss\MediaLibraryExtension\HasMedia\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasStaticLists, InteractsWithMedia, HasRoles;

    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $mediaSingleCollections = ['avatar']; 

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

        
    }
    public function rewiews()
    {
        return $this->belongsTo(Review::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile(); 
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatars') ?: null;
    }

    public function routeNotificationForTurboSMS()
    {
        return $this->phone;
    }

    public static function statusList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::STATUS_ACTIVE,
                //'name' => trans('lists.category_type.' . self::ARTICLE_TYPE . '.name'),
                'name'=>'actiive',
            ],
            [
                'key' => self::STATUS_BLOCKED,
                //'name' => trans('lists.category_type.' . self::PRODUCT_TYPE . '.name'),
                'name'=>'blocked'
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }


     // фільтрувіання та сортування
    public function scopeFilterNameEmail($query, $search)
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
    }

    public function scopeFilterRoles($query, $roles)
    {
        if (!empty($roles)) {
            $query->whereHas('roles', function ($q) use ($roles) {
                $q->whereIn('name', (array) $roles);
            });
        }
    }

    public function scopeFilterDate($query, $date)
    {
        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }
    }

    public function scopeSortBy($query, $sortBy, $direction)
    {
        if (!empty($sortBy)) {
            $direction = $direction === 'desc' ? 'desc' : 'asc';
            $query->orderBy($sortBy, $direction);
        }
    }

    public function scopeFilter($query, $request)
    {
        return $query
            ->filterNameEmail($request->input('search'))
            ->filterRoles($request->input('roles'))
            ->filterDate($request->input('registered_at'))
            ->sortBy($request->input('sort_by'), $request->input('direction'));
    }
}

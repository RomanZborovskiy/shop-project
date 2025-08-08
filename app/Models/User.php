<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\HasStaticLists;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasStaticLists;

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
}

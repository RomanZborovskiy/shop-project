<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;

    const TYPE_CONTACT = 'contact';
    const TYPE_CALLME = 'callme';

    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'fields' => 'array',
    ];

    public static function typesList(string $columnKey = null, string $indexKey = null, array $options = []): array
    {
        $records = [
            [
                'key' => self::TYPE_CONTACT,
                'name' => trans('lists.order_statuses.' . self::TYPE_CONTACT . '.name'),
            ],
            [
                'key' => self::TYPE_CALLME,
                'name' => trans('lists.order_statuses.' . self::TYPE_CALLME . '.name'),
            ],
        ];

        return self::staticListBuild($records, $columnKey, $indexKey, $options);
    }
}

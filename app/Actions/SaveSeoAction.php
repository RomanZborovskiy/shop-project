<?php

namespace App\Actions;


use Illuminate\Database\Eloquent\Model;

class SaveSeoAction
{
    public function execute(Model $model, array $seo, string $group = 'ua'): void
    {
        if (empty($seo)) {
            return;
        }

        $model->seo()->updateOrCreate(
            [
                'group' => $group,
            ],
            [
                'tags'  => $seo,
                'group' => $group,
            ]
        );
    }
}
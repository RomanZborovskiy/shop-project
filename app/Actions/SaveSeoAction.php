<?php

namespace App\Actions;


use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveSeoAction
{
    use AsAction;
    public function handle(Model $model, array $seo, string $group = 'ua'): void
    {
        if (empty($seo)) {
            return;
        }

        $model->seo()->updateOrCreate(
            [
                'group'       => $group,
                'model_id'    => $model->getKey(),
                'model_type'  => $model->getMorphClass(),
            ],
            [
                'tags'  => $seo,
                'group' => $group,
            ]
        );
    }
}
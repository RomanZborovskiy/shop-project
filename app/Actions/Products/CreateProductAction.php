<?php

namespace App\Actions\Products;

use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateProductAction
{
    use AsAction;

    public function handle(array $data)
    {
        return Product::create($data);
    }
}

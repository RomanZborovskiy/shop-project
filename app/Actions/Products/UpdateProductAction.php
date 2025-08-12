<?php

namespace App\Actions\Products;

use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateProductAction
{
    use AsAction;

    public function handle(Product $product, array $data, $request)
    {
        $product->update($data);
        $product->mediaManage($request);
        return $product;
    }
}

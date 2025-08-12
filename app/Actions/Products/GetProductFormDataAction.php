<?php

namespace App\Actions\Products;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Property;
use Lorisleiva\Actions\Concerns\AsAction;

class GetProductFormDataAction
{
    use AsAction;

    public function handle(array $filters = [])
    {
        $brands = Brand::pluck('name', 'id');
        $categories = Category::where('type', 'product')->get();
        $attributes = Attribute::all();

        $properties = collect();
        if (!empty($filters['attribute_id'])) {
            $properties = Property::where('attribute_id', $filters['attribute_id'])->get();
        }

        return compact('brands', 'categories', 'attributes', 'properties');
    }
}

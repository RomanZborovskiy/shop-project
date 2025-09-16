<?php

namespace App\Imports;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\Term;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $brand = Brand::firstOrCreate(['name' => $row['brand']]);
        $category = Term::firstOrCreate([
                'name' => $row['category'],
                'vocabulary' => 'categories',
                'slug' => Str::slug($row['category']),
            ]);

         $product = Product::create([
            'name'=> $row['name'],
            'sku'=> $row['sku'],
            'price'=> $row['price'],
            'price_old'=> $row['price_old'],
            'brand_id'=> $brand->id,
            'category_id'=> $category->id,
            'description'=> $row['body'],
        ]);

        $images = array_filter(array_map('trim', explode(',', $row['images'])));

        foreach ($images as $imageUrl) {{}
            $product
                ->addMediaFromUrl($imageUrl)
                ->toMediaCollection('images');
        }

        $attributes = $this->parseAttributes($row['attributes']);
        foreach ($attributes as $attrName => $attrValue) {
            $attribute = Attribute::firstOrCreate(['name' => $attrName]);

            $property = Property::firstOrCreate([
                'attribute_id' => $attribute->id,
                'value'        => $attrValue
            ]);

            $product->properties()->syncWithoutDetaching([$property->id]);
        }

        return $product;
    }

    private function parseAttributes($string)
    {
        $attributes = [];
        foreach (explode('|', $string) as $attr) {
            if (str_contains($attr, ':')) {
                [$key, $value] = array_map('trim', explode(':', $attr, 2));
                $attributes[$key] = $value;
            }
        }
        return $attributes;
    }
    
}

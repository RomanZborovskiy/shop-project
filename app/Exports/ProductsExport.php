<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['brand', 'category', 'properties.attribute'])
            ->get()
            ->map(function ($product) {
                $attributesString = $product->properties->map(function ($property) {
                $attributeName = $property->attribute?->name;
                return $attributeName . ': ' . $property->value;
            })->implode(' | ');
                return [
                    'Name'=> $product->name,
                    'Sku'=> $product->sku,
                    'Price'=> $product->price,
                    'Price_Old'=> $product->price_old,
                    'Attributes'=> $attributesString,
                    'Brand'=> $product->brand?->name,
                    'Category'=> $product->category?->name,
                    'Images'=> $product->getMedia('images')->pluck('original_url')->implode(', '),
                    'Body'=> $product->description,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Sku',
            'Price',
            'Price_Old',
            'Attributes',
            'Brand',
            'Category',
            'Images',
            'Body',
        ];
    }
}

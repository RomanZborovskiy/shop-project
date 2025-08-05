<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Property;
use Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Propertyable>
 */
class PropertyableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::inRandomOrder()->value('id'),
            'product_id' => Product::inRandomOrder()->value('id'),
        ];
    }
}

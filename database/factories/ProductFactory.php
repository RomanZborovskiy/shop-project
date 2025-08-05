<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name' => ucfirst($name),
            'description' => $this->faker->optional()->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'old_price' => $this->faker->optional()->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(0, 100),
            'sku' => strtoupper(Str::random(10)),
            'slug' => Str::slug($name) . '-' . Str::random(5),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
        ];
    }
}

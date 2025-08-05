<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();

        $quantity = $this->faker->numberBetween(1, 5);
        $price = $product ? $product->price * $quantity : $this->faker->randomFloat(2, 10, 100);

        return [
            'price' => $price,
            'quantity' => $quantity,
            'product_id' => $product?->id ?? Product::factory(), 
            'order_id' => Order::inRandomOrder()->value('id'),
        ];
    }
}

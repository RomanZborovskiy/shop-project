<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class CategoryAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::inRandomOrder()->value('id') ?? Attribute::factory(),
            'category_id' => Term::where('vocabulary', 'categories')->inRandomOrder()->value('id')
                ?? Term::factory()->state(['vocabulary' => 'categories']),
        ];
    }
}

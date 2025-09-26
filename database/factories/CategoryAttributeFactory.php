<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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

        $attributes = Attribute::pluck('id')->all();


        $categories = Term::where('vocabulary', 'categories')->pluck('id')->all();


        $allPairs = collect($attributes)->crossJoin($categories)->toArray();

        [$attributeId, $categoryId] = fake()->unique()->randomElement($allPairs);

        return [
            'attribute_id' => $attributeId,
            'category_id'  => $categoryId,
        ];
    }
}

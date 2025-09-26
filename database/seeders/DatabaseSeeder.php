<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Property;
use App\Models\Propertyable;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryAttributeFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        $this->call([
            PageSeeder::class,
            TaxonomySeeder::class,
        ]);
        User::factory(10)->create();
        Brand::factory()->count(10)->create();
        Attribute::factory()->count(10)->create();
        Product::factory()->count(10)->create();
        Review::factory()->count(10)->create();
        Property::factory()->count(50)->create();
        Propertyable::factory()->count(10)->create();
        Post::factory()->count(10)->create();
        Order::factory()->count(10)->create();
        Purchase::factory()->count(30)->create();
        Lead::factory()->count(30)->create();
        CategoryAttribute::factory()->count(12)->create();
        $this->call([
            PropertySeeder::class,
            PrimarySeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'name' => 'Головна',
                'description' => 'Це головна сторінка сайту.',
                'template' => 'home',
            ],
            [
                'name' => 'Про нас',
                'description' => 'Інформація про компанію.',
                'template' => 'about',
            ],
            [
                'name' => 'Доставка',
                'description' => 'Місця доставки.',
                'template' => 'delivery',
            ],
            [
                'name' => 'Політика конфіденційності',
                'description' => null,
                'template' => 'policy',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate([
                'name' => $page['name'],
                'description' => $page['description'],
                'template' => $page['template'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

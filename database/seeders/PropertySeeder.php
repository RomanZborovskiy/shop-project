<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("properties")->insert([
            ['attribute_id'=>'1', 'value'=>'Червоний'],
            ['attribute_id'=>'1', 'value'=>'Зелений'],
            ['attribute_id'=>'2', 'value'=>'XS'],
            ['attribute_id'=>'2', 'value'=>'S'],
            ['attribute_id'=>'2', 'value'=>'M'],
            ['attribute_id'=>'2', 'value'=>'L'],
        ]);
    }
}

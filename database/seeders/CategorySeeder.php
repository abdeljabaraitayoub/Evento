<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Concerts',
        ]);

        Category::factory()->create([
            'name' => 'Theater',
        ]);

        Category::factory()->create([
            'name' => 'Sports',
        ]);

        Category::factory()->create([
            'name' => 'Movies',
        ]);

        Category::factory()->create([
            'name' => 'Festivals',
        ]);

        Category::factory()->create([
            'name' => 'Museums',
        ]);

        Category::factory()->create([
            'name' => 'Parks',
        ]);

        Category::factory()->create([
            'name' => 'Restaurants',
        ]);

        Category::factory()->create([
            'name' => 'Bars',
        ]);

        Category::factory()->create([
            'name' => 'Clubs',
        ]);

        Category::factory()->create([
            'name' => 'Cafes',
        ]);
    }
}

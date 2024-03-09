<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert(['name' => 'Tanger-Tetouan-Al Hoceima']);
        DB::table('regions')->insert(['name' => 'Oriental']);
        DB::table('regions')->insert(['name' => 'Fès-Meknès']);
        DB::table('regions')->insert(['name' => 'Rabat-Salé-Kénitra']);
        DB::table('regions')->insert(['name' => 'Béni Mellal-Khénifra']);
        DB::table('regions')->insert(['name' => 'Casablanca-Settat']);
        DB::table('regions')->insert(['name' => 'Marrakech-Safi']);
        DB::table('regions')->insert(['name' => 'Drâa-Tafilalet']);
        DB::table('regions')->insert(['name' => 'Souss-Massa']);
        DB::table('regions')->insert(['name' => 'Guelmim-Oued Noun']);
        DB::table('regions')->insert(['name' => 'Laâyoune-Sakia El Hamra']);
        DB::table('regions')->insert(['name' => 'Dakhla-Oued Ed-Dahab']);
    }
}

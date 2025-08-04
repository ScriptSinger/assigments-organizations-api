<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Building::insert([
            ['address' => 'г. Уфа, ул. Ленина 1', 'latitude' => 54.7388, 'longitude' => 55.9721],
            ['address' => 'г. Уфа, ул. Ленина 3', 'latitude' => 54.7389, 'longitude' => 55.9722], // рядом с первым
            ['address' => 'г. Уфа, пр. Октября 10', 'latitude' => 54.7500, 'longitude' => 55.9600], // подальше
        ]);
    }
}

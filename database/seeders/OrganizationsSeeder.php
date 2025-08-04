<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $org1 = Organization::create(['name' => 'ООО Рога и Копыта', 'building_id' => 1]);
        $org2 = Organization::create(['name' => 'Молочный Мир', 'building_id' => 2]);
        $org3 = Organization::create(['name' => 'АвтоГруз', 'building_id' => 3]);
        $org4 = Organization::create(['name' => 'Мясная Лавка', 'building_id' => 1]); // В том же здании, что и org1

        OrganizationPhone::insert([
            ['organization_id' => $org1->id, 'phone' => '2-222-222'],
            ['organization_id' => $org1->id, 'phone' => '3-333-333'],
            ['organization_id' => $org2->id, 'phone' => '8-923-666-13-13'],
            ['organization_id' => $org4->id, 'phone' => '7-777-777'],
        ]);

        $meat = Activity::where('name', 'Мясная продукция')->first();
        $milk = Activity::where('name', 'Молочная продукция')->first();
        $trucks = Activity::where('name', 'Грузовые')->first();

        $org1->activities()->attach($meat);
        $org2->activities()->attach($milk);
        $org3->activities()->attach($trucks);
        $org4->activities()->attach($meat); // Мясная лавка тоже к мясной продукции
    }
}

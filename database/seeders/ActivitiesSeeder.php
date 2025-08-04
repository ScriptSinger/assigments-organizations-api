<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        // 1-й уровень
        $food = Activity::create(['name' => 'Еда']);
        $cars = Activity::create(['name' => 'Автомобили']);

        // 2-й уровень
        $meat = Activity::create(['name' => 'Мясная продукция', 'parent_id' => $food->id]);
        $milk = Activity::create(['name' => 'Молочная продукция', 'parent_id' => $food->id]);

        $trucks = Activity::create(['name' => 'Грузовые', 'parent_id' => $cars->id]);
        $light = Activity::create(['name' => 'Легковые', 'parent_id' => $cars->id]);

        // 3-й уровень (подкатегории)
        $spareParts = Activity::create(['name' => 'Запчасти', 'parent_id' => $light->id]);
        $accessories = Activity::create(['name' => 'Аксессуары', 'parent_id' => $light->id]);

        // Дополнительный 3-й уровень для примера
        Activity::create(['name' => 'Двигатели', 'parent_id' => $spareParts->id]);
        Activity::create(['name' => 'Шины', 'parent_id' => $spareParts->id]);
        Activity::create(['name' => 'Чехлы', 'parent_id' => $accessories->id]);
    }
}

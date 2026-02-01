<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $meals = [
            ['name' => 'Chicken Shawarma', 'name_ar' => 'شاورما دجاج', 'price' => 45.00, 'category' => 'أطباق رئيسية'],
            ['name' => 'Beef Shawarma', 'name_ar' => 'شاورما لحم', 'price' => 55.00, 'category' => 'أطباق رئيسية'],
            ['name' => 'Falafel Sandwich', 'name_ar' => 'سندوتش فلافل', 'price' => 15.00, 'category' => 'سندوتشات'],
            ['name' => 'Chicken Burger', 'name_ar' => 'برجر دجاج', 'price' => 35.00, 'category' => 'سندوتشات'],
            ['name' => 'Beef Burger', 'name_ar' => 'برجر لحم', 'price' => 40.00, 'category' => 'سندوتشات'],
            ['name' => 'Pepsi', 'name_ar' => 'بيبسي', 'price' => 8.00, 'category' => 'مشروبات'],
            ['name' => '7UP', 'name_ar' => 'سفن أب', 'price' => 8.00, 'category' => 'مشروبات'],
            ['name' => 'Water', 'name_ar' => 'مياه معدنية', 'price' => 5.00, 'category' => 'مشروبات'],
            ['name' => 'Orange Juice', 'name_ar' => 'عصير برتقال', 'price' => 12.00, 'category' => 'مشروبات'],
            ['name' => 'Kunafa', 'name_ar' => 'كنافة', 'price' => 25.00, 'category' => 'حلويات'],
            ['name' => 'Baklava', 'name_ar' => 'بقلاوة', 'price' => 30.00, 'category' => 'حلويات'],
        ];

        foreach ($meals as $meal) {
            Meal::create($meal);
        }
    }
}

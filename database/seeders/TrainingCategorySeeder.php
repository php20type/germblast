<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingCategory;

class TrainingCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Core', 'sort_order' => 1],
            ['name' => 'HazCom', 'sort_order' => 2],
            ['name' => 'Leadership', 'sort_order' => 3],
            ['name' => 'Science', 'sort_order' => 4],
            ['name' => 'Service', 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            TrainingCategory::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}

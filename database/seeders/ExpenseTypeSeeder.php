<?php

namespace Database\Seeders;

use App\Models\ExpenseType;
use Illuminate\Database\Seeder;

class ExpenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseTypes = [
            ['name' => 'Meals'],
            ['name' => 'Service Supplies'],
            ['name' => 'Avertising/Promotion'],
            ['name' => 'Travel Expenses'],
            ['name' => 'Repairs'],
            ['name' => 'Computers/Software'],
            ['name' => 'Continuing Education'],
            ['name' => 'Office Supplies'],
            ['name' => 'Conferences/Tradeshows'],
        ];

        foreach ($expenseTypes as $type) {
            ExpenseType::create($type);
        }
    }
}


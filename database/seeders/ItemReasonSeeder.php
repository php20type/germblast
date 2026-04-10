<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseItemReason;

class ItemReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $reasons = [
            ['name' => 'Approved'],
            ['name' => 'Not an approved expense'],
            ['name' => 'Picture is unusable'],
            ['name' => 'Tip exceeds allowable amount'],
            ['name' => 'Other'],
        ];

        foreach ($reasons as $reason) {
            ExpenseItemReason::create($reason);
        }
    }
}

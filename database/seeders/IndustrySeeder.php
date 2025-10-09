<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            ['id' => 1, 'name' => 'Church/Day Care'],
            ['id' => 2, 'name' => 'Construction'],
            ['id' => 3, 'name' => 'Education'],
            ['id' => 4, 'name' => 'Educational Services'],
            ['id' => 5, 'name' => 'Entertainment'],
            ['id' => 6, 'name' => 'Environmental'],
            ['id' => 7, 'name' => 'Fitness/Gyms'],
            ['id' => 8, 'name' => 'Government'],
            ['id' => 9, 'name' => 'Healthcare Providers'],
            ['id' => 10, 'name' => 'Hospitals and Health Care'],
            ['id' => 11, 'name' => 'Law Enforcement'],
            ['id' => 12, 'name' => 'Lodging & Gaming'],
            ['id' => 13, 'name' => 'Manufacturing'],
            ['id' => 14, 'name' => 'Medical Practices'],
            ['id' => 15, 'name' => 'Offices/Office Building'],
            ['id' => 16, 'name' => 'Real Estate'],
            ['id' => 17, 'name' => 'Residential'],
            ['id' => 18, 'name' => 'Restaurant & Food Manufacturing'],
            ['id' => 19, 'name' => 'Retail'],
            ['id' => 20, 'name' => 'School Athletics'],
            ['id' => 21, 'name' => 'Transportation'],
            ['id' => 22, 'name' => 'Veterinarian'],
        ];

        foreach ($industries as $industry) {
            Industry::updateOrCreate(
                ['id' => $industry['id']],
                ['name' => $industry['name']]
            );
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Industry;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            'Church/Day Care',
            'Construction',
            'Education',
            'Educational Services',
            'Entertainment',
            'Environmental',
            'Fitness/Gyms',
            'Government',
            'Healthcare Providers',
            'Hospitals and Health Care',
            'Law Enforcement',
            'Lodging & Gaming',
            'Manufacturing',
            'Medical Practices',
            'Offices/Office Building',
            'Real Estate',
            'Residential',
            'Restaurant & Food Manufacturing',
            'Retail',
            'School Athletics',
            'Transportation',
            'Veterinarian',
        ];

        foreach ($industries as $industry) {
            Industry::create(['name' => $industry]);
        }

    }
}

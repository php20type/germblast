<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyType;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $company_types = [
            'Prospect',
            'Customer',
        ];

        foreach ($company_types as $company_type) {
            CompanyType::create(['type' => $company_type]);
        }
    }
}

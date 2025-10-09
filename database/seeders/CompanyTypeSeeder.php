<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company_types = [
            ['id' => 1, 'type' => 'Prospect'],
            ['id' => 2, 'type' => 'Customer'],
        ];

        foreach ($company_types as $company_type) {
            CompanyType::updateOrCreate(
                ['id' => $company_type['id']],
                ['type' => $company_type['type']]
            );
        }

    }
}

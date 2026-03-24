<?php

namespace Database\Seeders;

use App\Models\Territory;
use Illuminate\Database\Seeder;

class TerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $territories = [
            ['id' => 1, 'name' => 'Lubbock, TX',         'franchise_name' => 'Infection Controls, Inc.'],
            ['id' => 2, 'name' => 'New Mexico',           'franchise_name' => 'GermBlast New Mexico'],
            ['id' => 3, 'name' => 'Colorado',             'franchise_name' => 'GermBlast Colorado Franchise'],
            ['id' => 4, 'name' => 'Dallas, TX',           'franchise_name' => 'Infection Controls, Inc.'],
            ['id' => 5, 'name' => 'Austin, TX',           'franchise_name' => 'Infection Controls, Inc.'],
            ['id' => 6, 'name' => 'Houston, TX',          'franchise_name' => 'Infection Controls, Inc.'],
            ['id' => 7, 'name' => 'El Paso, TX',          'franchise_name' => 'Infection Controls, Inc.'],
        ];

        foreach ($territories as $territory) {
            Territory::updateOrCreate(
                ['id' => $territory['id']],
                [
                    'name'           => $territory['name'],
                    'franchise_name' => $territory['franchise_name'],
                ]
            );
        }
    }
}

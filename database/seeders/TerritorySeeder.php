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
            ['id' => 1, 'name' => 'Lubbock Office'],
            ['id' => 2, 'name' => 'New Mexico'],
            ['id' => 3, 'name' => 'Colorado Franchise'],
            ['id' => 4, 'name' => 'Dallas Fort Worth - North/North East Texas'],
            ['id' => 5, 'name' => 'Austin Office - Central Texas'],
            ['id' => 6, 'name' => 'Houston Office'],
            ['id' => 7, 'name' => 'El Paso Office'],
        ];

        foreach ($territories as $territory) {
            Territory::updateOrCreate(
                ['id' => $territory['id']],
                ['name' => $territory['name']]
            );
        }
    }
}

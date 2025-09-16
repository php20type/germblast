<?php

namespace Database\Seeders;

use App\Models\Territory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $territories = [
            'Lubbock Office',
            'New Mexico',
            'Colorado Franchise',
            'Dallas Fort Worth - North/North East Texas',
            'Austin Office - Central Texas',
            'Houston Office',
            'El Paso Office'
        ];

        foreach ($territories as $territory) {
            Territory::create(['name' => $territory]);
        }
    }
}

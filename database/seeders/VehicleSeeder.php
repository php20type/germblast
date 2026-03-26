<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $vehicles = [
            ['id' => 1, 'name' => '021 E350 Econoline 8571'],
            ['id' => 2, 'name' => '003 Ram Promaster 3218'],
            ['id' => 3, 'name' => '002 Ram Promaster 3220'],
            ['id' => 4, 'name' => '008 Ram Promaster 0226'],
            ['id' => 5, 'name' => '018 Ram Promaster 0231'],
            ['id' => 6, 'name' => '010 Transit 6725'],
            ['id' => 7, 'name' => '013 Transit 3804'],
            ['id' => 8, 'name' => 'Wash Trailer 4 8308'],
            ['id' => 9, 'name' => 'Wash Trailer 3 2877'],
            ['id' => 10, 'name' => '017 Transit Connect 6958'],
            ['id' => 11, 'name' => '005 Transit Connect 8533'],
            ['id' => 12, 'name' => '016 Transit 1392'],
            ['id' => 13, 'name' => '007 Ram Promaster City 3587'],
            ['id' => 14, 'name' => '012 Transit 0581'],
            ['id' => 15, 'name' => '020 Transit Connect 6066'],
            ['id' => 16, 'name' => '014 Transit Connect 5842'],
            ['id' => 17, 'name' => '011 Transit 6067'],
            ['id' => 18, 'name' => '002 Ford F250 7050'],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['id' => $vehicle['id']],
                [
                    'name'           => $vehicle['name']
                ]
            );
        }
    }
}

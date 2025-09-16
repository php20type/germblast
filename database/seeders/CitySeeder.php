<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ini_set('memory_limit', '512M');

        $citiesJSON = File::get(database_path('data/cities.json'));
        $cities = json_decode($citiesJSON, true);

        foreach ($cities as $city) {
            // Create the city
            $city = City::create([
                'id' => $city['id'],
                'name' => $city['name'],
                'state_id' => $city['state_id'],
                'country_id' => $city['country_id'],
            ]);
        }
    }
}

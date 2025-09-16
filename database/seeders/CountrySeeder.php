<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countriesJSON = File::get(database_path('data/countries.json'));
        $countries = json_decode($countriesJSON, true);

        foreach ($countries as $country) {
            // Create the country
            $country = Country::create([
                'id' => $country['id'],
                'name' => $country['name'],
                'country_code' => $country['phone_code'],
                'short_name' => $country['iso2'],
                'nationality' => $country['nationality'],
            ]);
        }
    }
}

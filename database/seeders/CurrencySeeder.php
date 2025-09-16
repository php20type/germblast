<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencyJSON = File::get(database_path('data/currencies.json'));
        $currencies = json_decode($currencyJSON, true);

        foreach ($currencies as $currency) {
            // Create the state
            $currency = Currency::create([
                'code' => $currency['code'],
                'name' => $currency['name'],
                'USDexchangerate' => $currency['USDexchangerate'],
            ]);
        }
    }
}

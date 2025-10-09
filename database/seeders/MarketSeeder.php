<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Market;

class MarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $markets = [
            ['id' => 1, 'name' => 'U.S'],
            ['id' => 2, 'name' => 'A.E.D'],
            ['id' => 3, 'name' => 'A.F.N'],
            ['id' => 4, 'name' => 'A.L.L'],
            ['id' => 5, 'name' => 'A.M.D'],
        ];

        foreach ($markets as $market) {
            Market::updateOrCreate(
                ['id' => $market['id']],
                ['name' => $market['name']]
            );
        }
    }
}

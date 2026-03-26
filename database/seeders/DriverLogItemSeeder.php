<?php

namespace Database\Seeders;

use App\Models\DriverLogItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverLogItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['id' => 15, 'name' => 'Defensive Driving Completed', 'points' => null],
            ['id' => 14, 'name' => 'Remedial Driver Training', 'points' => null],
            ['id' => 12, 'name' => 'Initial Driver Training', 'points' => null],
            ['id' => 13, 'name' => 'Refresher Driver Training', 'points' => null],

            ['id' => 4, 'name' => 'Failure to adhere to FSM rules', 'points' => 1],
            ['id' => 2, 'name' => 'Hard braking', 'points' => 1],
            ['id' => 3, 'name' => 'Hard cornering', 'points' => 1],
            ['id' => 1, 'name' => 'Speeding', 'points' => 1],

            ['id' => 6, 'name' => 'Citation from law enforcement', 'points' => 2],
            ['id' => 5, 'name' => 'Removal of Vehicle GPS device', 'points' => 2],
            ['id' => 7, 'name' => 'Using mobile device while driving', 'points' => 2],

            ['id' => 8, 'name' => 'At fault collision - not a total loss', 'points' => 3],
            ['id' => 9, 'name' => 'Preventable collision - not a total loss', 'points' => 3],

            ['id' => 10, 'name' => 'At fault collision - total loss', 'points' => 4],
            ['id' => 11, 'name' => 'Avoidable collision - total loss', 'points' => 4],
        ];

        foreach ($items as $item) {
            DriverLogItem::updateOrCreate(
                ['id' => $item['id']],
                [
                    'name'           => $item['name'],
                    'points'           => $item['points']
                ]
            );
        }
    }
}

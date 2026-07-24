<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\FacilityRoomType;

class FacilityRoomTypeSeeder extends Seeder
{
     public function run(): void
    {
        // Load JSON file
        $json = File::get(database_path('data/facility_room_types.json'));
        $roomTypes = json_decode($json, true);

        // If JSON accidentally comes as single object
        if (isset($roomTypes['id'])) {
            $roomTypes = [$roomTypes];
        }

        foreach ($roomTypes as $type) {
            FacilityRoomType::updateOrCreate(
                ['id' => $type['id']],
                [
                    'input_name'     => $type['input_name'],
                    'name'           => $type['name'],
                    'hours_required' => $type['hours_required'] ?? 0,
                    'facility_types' => $type['facility_types'] ?? [],
                ]
            );
        }
    }
}

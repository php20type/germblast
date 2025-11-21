<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\EquipmentType;


class EquipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Load JSON file
        $json = File::get(database_path('data/equipment_types.json'));
        $equipmentTypes = json_decode($json, true);

        // If JSON accidentally comes as single object
        if (isset($equipmentTypes['id'])) {
            $equipmentTypes = [$equipmentTypes];
        }

        foreach ($equipmentTypes as $type) {
            EquipmentType::create([
                'id'   => $type['id'],
                'input_name' => $type['input_name'],
                'name' => $type['name'],
                'type' => $type['type'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EquipmentManagementType;


class EquipmentManagementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $types = [
            'Equipment Cart',
            'Victory Handheld Sprayer',
            'Karcher Sprayer',
            'Victory Backpack Sprayer',
            'XT-3 Sprayer',
            'Dupray Steamer',
            'HaloFogger',
            'ATP Meter',
            'Monster Mop',
            'Emist Backpack',
            'Shop Vac',
            'PCO 1000G3',
            'Thermometer',
            'Decon Trough',
            'Trash Cart',
            'Emist Handheld',
            'Daimer Steamer',
            'PCO 3000G3',
            'PCO 3000G3X',
            'PCO 5000',
            'Siphon Pumps',
            'GB Air Units',
            'ESS Sprayer',
        ];

        foreach ($types as $type) {
            EquipmentManagementType::create([
                'name' => $type
            ]);
        }
    }
}

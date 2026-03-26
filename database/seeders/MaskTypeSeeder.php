<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaskType;

class MaskTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            '3M 6000 - Small',
            '3M 6000 - Medium',
            '3M 6000 - Large',
            '3M Ultimate FX - Small',
            '3M Ultimate FX - Medium',
            '3M Ultimate FX - Large',
        ];

        foreach ($types as $type) {
            MaskType::updateOrCreate(
                ['name' => $type]
            );
        }
    }
}

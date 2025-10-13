<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\ActivityType;


class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activity_typesJSON = File::get(database_path('data/activity_types.json'));
        $activity_types = json_decode($activity_typesJSON, true);

        // If JSON is a single object, wrap it as an array
        if (isset($activity_types['id'])) {
            $activity_types = [$activity_types];
        }

        foreach ($activity_types as $activity_type) {
            ActivityType::create([
                'id' => $activity_type['id'],
                'type' => $activity_type['type'],
                'icon' => $activity_type['icon'],
            ]);
        }
    }
}

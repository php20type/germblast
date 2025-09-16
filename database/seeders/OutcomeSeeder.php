<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Outcome;

class OutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outcomesJSON = File::get(database_path('data/outcome.json'));
        $outcomes = json_decode($outcomesJSON, true);

        // If JSON is a single object, wrap it as an array
        if (isset($outcomes['outcome_id'])) {
            $outcomes = [$outcomes];
        }

        foreach ($outcomes as $outcome) {
            Outcome::create([
                'id' => $outcome['outcome_id'], // outcome_id → id
                'name' => $outcome['outcome'],    // outcome → name
            ]);
        }
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Competitor;

class CompetitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $competitorsJSON = File::get(database_path('data/competitors.json'));
        $competitors = json_decode($competitorsJSON, true);

        // If JSON is a single object, wrap it as an array
        if (isset($competitors['id'])) {
            $competitors = [$competitors];
        }

        foreach ($competitors as $competitor) {
            Competitor::create([
                'id' => $competitor['id'],
                'name' => $competitor['name'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statesJSON = File::get(database_path('data/states.json'));
        $states = json_decode($statesJSON, true);

        foreach ($states as $state) {
            // Create the state
            $state = State::create([
                'id' => $state['id'],
                'name' => $state['name'],
                'state_id' => $state['id'],
                'country_id' => $state['country_id'],
            ]);
        }
    }
}

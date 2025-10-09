<?php

namespace Database\Seeders;

use App\Models\LeadStage;
use Illuminate\Database\Seeder;

class LeadStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['id' => 1, 'name' => 'Int. GB Presentation'],
            ['id' => 2, 'name' => 'Site Survey'],
            ['id' => 3, 'name' => 'Proposal Approval'],
            ['id' => 4, 'name' => 'Proposal Pres.'],
            ['id' => 5, 'name' => 'Rec. Signed Proposal'],
        ];

        foreach ($stages as $stage) {
            LeadStage::updateOrCreate(
                ['id' => $stage['id']],
                ['name' => $stage['name']]
            );
        }

    }
}

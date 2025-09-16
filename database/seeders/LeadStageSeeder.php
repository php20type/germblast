<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeadStage;
class LeadStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            'Int. GB Presentation',
            'Site Survey',
            'Proposal Approval',
            'Proposal Pres.',
            'Rec. Signed Proposal'
        ];

        foreach ($stages as $stage) {
            LeadStage::create(['name' => $stage]);
        }
    }
}

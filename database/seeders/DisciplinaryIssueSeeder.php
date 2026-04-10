<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DisciplinaryIssue;

class DisciplinaryIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $issues = [
            'Late',
            'Uniform',
            'Attitude',
            'Communication',
            'Speed',
            'Performance',
            'Driving',
            'Other'
        ];

        foreach ($issues as $issue) {
            DisciplinaryIssue::create([
                'name' => $issue,
            ]);
        }
    }
}

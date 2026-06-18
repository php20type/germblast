<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessFailure;
use App\Models\BusinessFailureDocumentation;
use App\Models\User;
use Carbon\Carbon;

class BusinessFailureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find a user or use Super Admin
        $user = User::where('email', 'superadmin@germblast.com')->first();
        
        // Seed Failure 1
        $failure1 = BusinessFailure::create([
            'title' => 'Server Outage during high peak service hours',
            'record_opened_date' => Carbon::now()->subDays(5)->toDateString(),
            'description' => 'The main service scheduling server was unresponsive for 2 hours, preventing technicians from logging details.',
            'created_by' => $user->id,
        ]);

        BusinessFailureDocumentation::create([
            'business_failure_id' => $failure1->id,
            'user_id' => $user->id,
            'notes' => 'Failure record opened. System administrator notified of database deadlock.',
            'created_at' => Carbon::now()->subDays(5)->toDateTimeString(),
        ]);

        BusinessFailureDocumentation::create([
            'business_failure_id' => $failure1->id,
            'user_id' => $user->id,
            'notes' => 'Root Cause Analysis: DB connection pool exhausted. Recommended increasing pool limits and adding memory optimization.',
            'created_at' => Carbon::now()->subDays(3)->toDateTimeString(),
        ]);

        BusinessFailureDocumentation::create([
            'business_failure_id' => $failure1->id,
            'user_id' => $user->id,
            'notes' => 'Resolution: Increased database connection capacity and scaled server resources. The scheduling server is fully operational now.',
            'created_at' => Carbon::now()->subDays(1)->toDateTimeString(),
        ]);

        // Seed Failure 2
        $failure2 = BusinessFailure::create([
            'title' => 'Equipment Dispatch Mismatch',
            'record_opened_date' => Carbon::now()->subDays(2)->toDateString(),
            'description' => 'Incorrect respirator masks loaded onto Service Vehicle 4 prior to dispatch.',
            'created_by' => $user->id,
        ]);

        BusinessFailureDocumentation::create([
            'business_failure_id' => $failure2->id,
            'user_id' => $user->id,
            'notes' => 'Failure record opened. Reported by dispatcher.',
            'created_at' => Carbon::now()->subDays(2)->toDateTimeString(),
        ]);

        BusinessFailureDocumentation::create([
            'business_failure_id' => $failure2->id,
            'user_id' => $user->id,
            'notes' => 'Corrective Action: Implemented double-verification checklist on vehicle log templates prior to leaving warehouse.',
            'created_at' => Carbon::now()->subHours(12)->toDateTimeString(),
        ]);
    }
}

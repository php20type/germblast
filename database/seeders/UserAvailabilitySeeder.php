<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EmployeeAvailability;

class UserAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            EmployeeAvailability::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'start_date' => '2026-01-01',
                    'end_date' => '2027-01-01',
                ],
                [
                    'avg_hours' => 40,
                    'max_hours' => 40,
                    'mon_start' => '00:00',
                    'mon_end' => '23:59',
                    'tue_start' => '00:00',
                    'tue_end' => '23:59',
                    'wed_start' => '00:00',
                    'wed_end' => '23:59',
                    'thu_start' => '00:00',
                    'thu_end' => '23:59',
                    'fri_start' => '00:00',
                    'fri_end' => '23:59',
                    'sat_start' => '00:00',
                    'sat_end' => '23:59',
                    'sun_start' => '00:00',
                    'sun_end' => '23:59',
                ]
            );
        }
    }
}

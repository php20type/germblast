<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\IsdSchool;
use App\Models\IsdCampus;
use App\Models\IsdAttendanceRecord;

class IsdAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/isd_attendance.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error("The data file database/data/isd_attendance.json does not exist.");
            return;
        }

        $json = File::get($jsonPath);
        $schools = json_decode($json, true);

        if (!$schools) {
            $this->command->error("Failed to decode JSON data or file is empty.");
            return;
        }

        foreach ($schools as $schoolData) {
            $school = IsdSchool::updateOrCreate(
                ['id' => $schoolData['school_id']],
                ['name' => $schoolData['school_name']]
            );

            if (isset($schoolData['campuses'])) {
                foreach ($schoolData['campuses'] as $campusData) {
                    $campus = IsdCampus::updateOrCreate(
                        ['id' => $campusData['campus_id']],
                        [
                            'isd_school_id' => $school->id,
                            'name' => $campusData['campus_name']
                        ]
                    );

                    if (isset($campusData['attendance_records'])) {
                        foreach ($campusData['attendance_records'] as $recordData) {
                            if (empty($recordData['school_year']) || empty($recordData['week'])) {
                                continue; // Skip invalid records
                            }

                            IsdAttendanceRecord::updateOrCreate(
                                [
                                    'isd_campus_id' => $campus->id,
                                    'school_year' => $recordData['school_year'],
                                    'week' => $recordData['week'] === '' ? 0 : $recordData['week'],
                                ],
                                [
                                    'ada' => $recordData['ada'] === '' ? 0 : $recordData['ada'],
                                    'pia' => $recordData['pia'] === '' ? 0 : $recordData['pia']
                                ]
                            );
                        }
                    }
                }
            }
        }

        $this->command->info("ISD Attendance data seeded successfully.");
    }
}

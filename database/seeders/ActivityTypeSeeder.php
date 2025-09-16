<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ActivityType;


class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            'Name',
            'Email',
            'Phone Call',
            'Initial Meeting/Prospecting',
            'Renewal Contract Delivered',
            'Site Survey',
            'MKT - Digital Media Kit',
            'MKT - Ind. Partner MKT Materials',
            'MKT - Protected Door Stickers',
            'MKT - Web Badge',
            'PH Campaign - Athletics Poster',
            'PH Campaign - COVID-19 Athletic Signage (Owen GRP)',
            'PH Campaign - COVID-19 Flyer',
            'PH Campaign - COVID-19 Poster',
            'PH Campaign - Electronic Initial Flyer w/logo',
            'PH Campaign - Flu Flyer',
            'PH Campaign - Flu Posters',
            'PH Campaign - Flu Vaccine Flyer',
            'PH Campaign - GB Partnership Poster',
            'PH Campaign - Hand Washing Kits',
            'PH Campaign - Initial Flyer',
            'PH Campaign - Newspaper Ad',
            'PH Campaign - Norovirus Flyer',
            'PH Campaign - Press Release',
            'PH Campaign - Social Media Hand Washing',
            'Sales - Initial Presentation utilizing GB Keynote',
            'Sales - New Signed Contract Received',
            'Sales - Proposal Review & Approval',
            'Sales - Prospecting Meeting',
            'Sales - Renewal Contract Received',
            'Sales - Site Survey Reports & Proposal Presentation',
            'Text Message',
        ];

        foreach ($activities as $activity) {
            ActivityType::create(['type' => $activity]);
        }
    }
}

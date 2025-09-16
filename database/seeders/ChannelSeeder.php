<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            'Organic Search',
            'Paid Search',
            'Organic Social',
            'Paid Social',
            'Email',
            'Direct Traffic',
            'Referral Traffic',
            'Traditional',
        ];

        foreach ($channels as $channel) {
            Channel::create(['name' => $channel]);
        }
    }
}

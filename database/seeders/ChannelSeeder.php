<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            ['id' => 1, 'name' => 'Organic Search'],
            ['id' => 2, 'name' => 'Paid Search'],
            ['id' => 3, 'name' => 'Organic Social'],
            ['id' => 4, 'name' => 'Paid Social'],
            ['id' => 5, 'name' => 'Email'],
            ['id' => 6, 'name' => 'Direct Traffic'],
            ['id' => 7, 'name' => 'Referral Traffic'],
            ['id' => 8, 'name' => 'Traditional'],
        ];

        foreach ($channels as $channel) {
            Channel::updateOrCreate(
                ['id' => $channel['id']],
                ['name' => $channel['name']]
            );
        }
    }
}

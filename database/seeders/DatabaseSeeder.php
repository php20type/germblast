<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(ActivityTypeSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ChannelSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(LeadStageSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(IndustrySeeder::class);
        $this->call(CompanyTypeSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(TerritorySeeder::class);
        $this->call(OutcomeSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

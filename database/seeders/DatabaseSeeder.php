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
        $this->call(CompetitorSeeder::class);
        $this->call(MarketSeeder::class);
        $this->call(FacilityRoomTypeSeeder::class);
        $this->call(EquipmentTypeSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(MaskTypeSeeder::class);
        $this->call(DriverLogItemSeeder::class);
        $this->call(DisciplinaryIssueSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LeadSeeder::class);
        $this->call(ExpenseTypeSeeder::class);
        $this->call(ItemReasonSeeder::class);
        $this->call(EquipmentManagementTypeSeeder::class);
        $this->call(InventoryItemSeeder::class);
        $this->call(BusinessFailureSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

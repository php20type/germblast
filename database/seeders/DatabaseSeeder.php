<?php

namespace Database\Seeders;

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

        // Roles and permissions (must run before the users, who are assigned roles)
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);

        // Reference data
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

        // Users, then their availability (without an availability record, employees do not appear
        // in Staff Assignment under Fulfill Order)
        $this->call(UserSeeder::class);
        $this->call(UserAvailabilitySeeder::class);

        $this->call(ExpenseTypeSeeder::class);
        $this->call(ItemReasonSeeder::class);
        $this->call(EquipmentManagementTypeSeeder::class);
        $this->call(InventoryItemSeeder::class);

        // Training (categories first, then the tests, then their questions)
        $this->call(TrainingCategorySeeder::class);
        $this->call(TrainingTestSeeder::class);
        $this->call(TrainingQuestionSeeder::class);

        $this->call(IsdAttendanceSeeder::class);
        $this->call(EvaluationQuestionsSeeder::class);
        $this->call(AuditQuestionsSeeder::class);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->decimal('value', 12, 4)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // The values the Survey Configuration page and the survey proposal pricing used to have hardcoded
        $now = now();
        $parameters = [
            ['travel_between', 'Travel Between', 0.33],
            ['miles_per_gallon', 'Miles Per Gallon', 14],
            ['price_per_gallon', 'Price Per Gallon', 3.00],
            ['awareness_percent', 'Awareness Percent', 0.1000],
            ['education_percent', 'Education Percent', 0.1000],
            ['technology_percent', 'Technology Percent', 0.0150],
            ['response_percent', 'Response Percent', 0.0900],
            ['sales_rep_percent', 'Sales Rep Percent', 0.1100],
            ['hourly_rate', 'Hourly Rate', 28.75],
            ['bus_cost', 'Bus Cost', 45.00],
            ['pricing_multiplier', 'Pricing Multiplier', 3.9],
            ['logistics_expense', 'Logistics Expense', 28.75],
        ];

        foreach ($parameters as $index => [$key, $label, $value]) {
            DB::table('survey_parameters')->insert([
                'key' => $key,
                'label' => $label,
                'value' => $value,
                'sort_order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_parameters');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('office_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // Seed default locations
        DB::table('office_locations')->insert([
            ['name' => 'Lubbock, TX',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Austin, TX',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dallas, TX',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'El Paso, TX',        'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Houston, TX',        'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Central America',    'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fort Myers, FL',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anytown, USA',       'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_locations');
    }
};

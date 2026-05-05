<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consumable_reports', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('user_id')->index();

            // Date/Time
            $table->dateTime('reported_at');

            // Microfiber Bins
            $table->decimal('micro_pre', 8, 2)->default(0)->nullable();
            $table->decimal('micro_post', 8, 2)->default(0)->nullable();

            // Disposable Microfiber Packs
            $table->decimal('disp_micro_pre', 8, 2)->default(0)->nullable();
            $table->decimal('disp_micro_post', 8, 2)->default(0)->nullable();

            // Halomist Gallons
            $table->decimal('halo_pre', 8, 2)->default(0)->nullable();
            $table->decimal('halo_post', 8, 2)->default(0)->nullable();

            // Opticide Gallons
            $table->decimal('opti_pre', 8, 2)->default(0)->nullable();
            $table->decimal('opti_post', 8, 2)->default(0)->nullable();

            // D2 Gallons
            $table->decimal('d2_pre', 8, 2)->default(0)->nullable();
            $table->decimal('d2_post', 8, 2)->default(0)->nullable();

            // Oxivir Bottles
            $table->decimal('oxi_pre', 8, 2)->default(0)->nullable();
            $table->decimal('oxi_post', 8, 2)->default(0)->nullable();

            // Shield Bottles
            $table->decimal('shld_pre', 8, 2)->default(0)->nullable();
            $table->decimal('shld_post', 8, 2)->default(0)->nullable();

            // Sterifab Gallons
            $table->decimal('sterl_pre', 8, 2)->default(0)->nullable();
            $table->decimal('sterl_post', 8, 2)->default(0)->nullable();

            // ATP Swabs
            $table->decimal('atp_pre', 8, 2)->default(0)->nullable();
            $table->decimal('atp_post', 8, 2)->default(0)->nullable();

            // Gloves (Boxes)
            $table->decimal('gloves_pre', 8, 2)->default(0)->nullable();
            $table->decimal('gloves_post', 8, 2)->default(0)->nullable();

            // Water Gallons
            $table->decimal('water_pre', 8, 2)->default(0)->nullable();
            $table->decimal('water_post', 8, 2)->default(0)->nullable();

            // Rinse Aid
            $table->decimal('rinse_pre', 8, 2)->default(0)->nullable();
            $table->decimal('rinse_post', 8, 2)->default(0)->nullable();

            // Wash Cleaner
            $table->decimal('wash_pre', 8, 2)->default(0)->nullable();
            $table->decimal('wash_post', 8, 2)->default(0)->nullable();

            // Rust Inhibitor
            $table->decimal('rust_pre', 8, 2)->default(0)->nullable();
            $table->decimal('rust_post', 8, 2)->default(0)->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumable_reports');
    }
};

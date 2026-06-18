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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('report_date');
            $table->decimal('inventory_val', 10, 2)->nullable();
            $table->decimal('reorder_point_val', 10, 2)->nullable();
            $table->string('unit')->nullable();
            $table->string('actions')->nullable();
            $table->boolean('warning')->default(false);
            $table->string('office')->default('Lubbock, TX');
            $table->string('supplier')->nullable();
            $table->text('details')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};

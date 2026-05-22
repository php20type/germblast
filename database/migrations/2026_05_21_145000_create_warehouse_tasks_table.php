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
        Schema::create('warehouse_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('supplier')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->string('reorder_point')->nullable();
            $table->string('reorder_quantity')->nullable();
            
            $table->tinyInteger('frequency')
                ->comment('1 = Daily, 2 = Twice/Week, 3 = Weekly, 4 = Monthly, 5 = Quarterly');
                
            $table->tinyInteger('form_type')
                ->comment('1 = Notes Only, 2 = Notes & Data, 3 = Vehicle Form, 4 = Trailer Form, 5 = Inventory Form');
                
            $table->unsignedBigInteger('vehicle_id')->nullable()->index();
            
            $table->string('last_performed_by')->nullable();
            $table->string('last_performed_on')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('due')->default(true);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_tasks');
    }
};

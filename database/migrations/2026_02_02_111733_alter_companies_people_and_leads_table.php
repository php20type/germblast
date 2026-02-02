<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         Schema::table('people', function (Blueprint $table) {
            $table->unsignedBigInteger('assignee_id')->nullable()->after('user_id')->index();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('assignee_id')->nullable()->after('user_id')->index();
            $table->unsignedBigInteger('sales_rep_id')->nullable()->after('assignee_id')->index();
            $table->unsignedBigInteger('account_manager_id')->nullable()->after('sales_rep_id')->index();
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('assignee_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('assignee_id');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'assignee_id',
                'sales_rep_id',
                'account_manager_id',
            ]);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
    }
};

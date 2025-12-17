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
        Schema::table('pensioners', function (Blueprint $table) {
            $table->integer('erp_id', false, true);
            $table->string('name');
            $table->string('register_no', 50);
            $table->integer('last_basic_salary', false, true);
            $table->integer('medical_allowance', false, true);
            $table->float('incentive_bonus');
            $table->string('bank_name');
            $table->string('account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->dropColumn(['erp_id', 'name', 'register_no', 'basic_salary', 'medical_allowance', 'incentive_bonus', 'bank_name', 'account_number']);
        });
    }
};

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
        Schema::table('offices', function (Blueprint $table) {
            $table->string('address');
            $table->string('mobile_no', 15);
            $table->string('email');
            $table->integer('office_code', false, true)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('mobile_no');
            $table->dropColumn('email');
            $table->dropUnique(['office_code']);
            $table->dropColumn('office_code');
        });
    }
};

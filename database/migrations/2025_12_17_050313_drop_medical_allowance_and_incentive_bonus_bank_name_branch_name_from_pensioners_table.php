<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->dropColumn([
                'medical_allowance',
                'incentive_bonus',
                'bank_name',
                'bank_branch_name',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->unsignedInteger('medical_allowance')->nullable();
            $table->double('incentive_bonus')->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_branch_name', 255)->nullable();
        });
    }
};

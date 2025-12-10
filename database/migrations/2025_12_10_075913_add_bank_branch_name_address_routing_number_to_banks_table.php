<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('branch_address');
            $table->string('routing_number', 9);
        });
    }

    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'branch_name', 'branch_address', 'routing_number']);
        });
    }
};

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
        Schema::table('officers', function (Blueprint $table) {
            $table->integer('erp_id', false, true);
            $table->string('name');
            $table->enum('designation', ['AD', 'SAD', 'DD']);
            $table->enum('role', ['ADMIN', 'USER', 'SUPER_ADMIN']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn(['erp_id', 'name', 'designation', 'role']);
        });
    }
};

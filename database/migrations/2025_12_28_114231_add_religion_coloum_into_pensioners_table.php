<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->enum('religion', ['Islam', 'Hinduism', 'Christianity', 'Buddhism', 'Others']);
        });
    }


    public function down(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->dropColumn('religion');
        });
    }
};

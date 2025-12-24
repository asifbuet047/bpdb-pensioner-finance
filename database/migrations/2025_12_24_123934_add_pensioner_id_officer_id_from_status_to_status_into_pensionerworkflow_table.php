<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pensionerworkflows', function (Blueprint $table) {
            $table->foreignId('pensioner_id')->constrained()->onDelete('cascade');
            $table->foreignId('officer_id')->constrained()->onDelete('cascade');
            $table->enum('status_from', ['floated', 'initiated', 'certified', 'approved']);
            $table->enum('status_to', ['floated', 'initiated', 'certified', 'approved']);
        });
    }

    public function down(): void
    {
        Schema::table('pensionerworkflows', function (Blueprint $table) {
            $table->dropForeign(['pensioner_id', 'officer_id']);
            $table->dropColumn(['pensioner_id', 'officer_id']);
            $table->dropColumn('status_from');
            $table->dropColumn('status_to');
        });
    }
};

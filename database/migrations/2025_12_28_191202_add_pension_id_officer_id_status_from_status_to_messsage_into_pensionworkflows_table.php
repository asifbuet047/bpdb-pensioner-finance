<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('pensionworkflows', function (Blueprint $table) {
            $table->foreignId('pension_id')->constrained()->onDelete('cascade');
            $table->foreignId('officer_id')->constrained()->onDelete('cascade');
            $table->enum('status_from', ['floated', 'initiated', 'certified', 'approved']);
            $table->enum('status_to', ['floated', 'initiated', 'certified', 'approved']);
            $table->text('message');
        });
    }

    public function down(): void
    {
        Schema::table('pensionworkflows', function (Blueprint $table) {
            $table->dropForeign(['pension_id']);
            $table->dropForeign(['officer_id']);
            $table->dropColumn([
                'pension_id',
                'officer_id',
                'status_from',
                'status_to',
                'message'
            ]);
        });
    }
};

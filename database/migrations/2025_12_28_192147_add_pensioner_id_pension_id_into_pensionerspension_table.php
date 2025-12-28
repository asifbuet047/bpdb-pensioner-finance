<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pensionerspensions', function (Blueprint $table) {
            $table->foreignId('pensioner_id')->constrained()->onDelete('cascade');
            $table->foreignId('pension_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pensionerspensions', function (Blueprint $table) {
            $table->dropForeign(['pensioner_id']);
            $table->dropForeign(['pension_id']);
            $table->dropColumn([
                'pensioner_id',
                'pension_id',
            ]);
        });
    }
};

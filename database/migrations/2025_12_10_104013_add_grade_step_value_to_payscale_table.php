<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payscales', function (Blueprint $table) {
            $table->string('grade', 10);
            $table->string('step', 10);
            $table->integer('basic', false, true);
        });
    }

    public function down(): void
    {
        Schema::table('payscales', function (Blueprint $table) {
            $table->dropColumn(['grade', 'step', 'basic']);
        });
    }
};

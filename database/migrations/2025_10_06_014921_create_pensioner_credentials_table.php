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
        Schema::create('pensioner_credentials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('pensioners_id')->constrained()->onDelete('cascade');
            $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pensioner_credentials');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->integer('designation_code', false, true);
            $table->string('description_english');
            $table->string('description_bangla');
            $table->enum('post_type', ['Officer', 'Staff']);
            $table->integer('order_number', false, true);
        });
    }

    public function down(): void
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->dropColumn(['designation_code', 'description_english', 'description_bangla', 'post_type', 'order_number']);
        });
    }
};

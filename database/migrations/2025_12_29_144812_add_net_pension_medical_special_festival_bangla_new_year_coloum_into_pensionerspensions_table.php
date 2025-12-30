<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('pensionerspensions', function (Blueprint $table) {
            $table->mediumInteger('net_pension', false)->unsigned();
            $table->mediumInteger('medical_allowance', false)->unsigned();
            $table->mediumInteger('special_allowance', false)->unsigned();
            $table->mediumInteger('festival_bonus', false)->unsigned();
            $table->mediumInteger('bangla_new_year_bonus', false)->unsigned();
            $table->boolean('is_block')->default(false);
            $table->text('message');
        });
    }


    public function down(): void
    {
        Schema::table('pensionerspensions', function (Blueprint $table) {
            $table->dropColumn([
                'net_pension',
                'medical_allowance',
                'special_allowance',
                'festival_bonus',
                'bangla_new_year_bonus',
                'is_block',
                'message',
            ]);
        });
    }
};

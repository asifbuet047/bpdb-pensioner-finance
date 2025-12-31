<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pensions', function (Blueprint $table) {
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('month', false)->unsigned();
            $table->smallInteger('year', false)->unsigned();
            $table->integer('sum_of_net_pension', false)->unsigned();
            $table->integer('sum_of_medical_allowance', false)->unsigned();
            $table->integer('sum_of_special_allowance', false)->unsigned();
            $table->integer('sum_of_festival_bonus', false)->unsigned();
            $table->integer('sum_of_bangla_new_year_bonus', false)->unsigned();
            $table->smallInteger('number_of_pensioners', false)->unsigned();
        });
    }


    public function down(): void
    {
        Schema::table('pensions', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn([
                'office_id',
                'month',
                'year',
                'sum_of_net_pension',
                'sum_of_medical_allowance',
                'sum_of_special_allowance',
                'sum_of_festival_bonus',
                'sum_of_bangla_new_year_bonus',
                'number_of_pensioners',
            ]);
        });
    }
};

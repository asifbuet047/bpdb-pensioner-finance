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
            $table->smallInteger('number_of_pensioners', false)->unsigned();
            $table->integer('total_amount', false)->unsigned();
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
                'number_of_pensioners',
                'total_amount',
            ]);
        });
    }
};

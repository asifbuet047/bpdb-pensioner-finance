<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_offices_banks', function (Blueprint $table) {
            $table->string('routing_number', 9);
            $table->string('account_name');
            $table->string('account_number');
            $table->string('erp_bank_code');
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('payment_offices_banks', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropColumn([
                'routing_number',
                'account_name',
                'account_number',
                'erp_bank_code',
                'office_id',
            ]);
        });
    }
};

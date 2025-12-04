<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {

            $table->integer('pension_payment_order', false, true);
            $table->string('name_bangla');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('spouse_name');
            $table->date('birth_date');
            $table->date('joining_date');
            $table->date('prl_start_date');
            $table->date('prl_end_date');
            $table->boolean('is_self_pension');
            $table->string('phone_number', 20);
            $table->string('email');
            $table->string('nid', 20);
            $table->string('bank_branch_name');
            $table->string('bank_routing_number', 20);
            $table->enum('status', ['pending', 'approved']);
            $table->boolean('verified');
            $table->boolean('biometric_verified');
            $table->enum('biometric_verification_type', ['face', 'fingerprint']);
        });
    }
    public function down(): void
    {
        Schema::table('pensioners', function (Blueprint $table) {
            $table->dropColumn('pension_payment_order');
            $table->dropColumn('name_bangla');
            $table->dropColumn('father_name');
            $table->dropColumn('mother_name');
            $table->dropColumn('spouse_name');
            $table->dropColumn('birth_date');
            $table->dropColumn('joining_date');
            $table->dropColumn('prl_start_date');
            $table->dropColumn('prl_end_date');
            $table->dropColumn('is_self_pension');
            $table->dropColumn('phone_number');
            $table->dropColumn('email');
            $table->dropColumn('nid');
            $table->dropColumn('bank_branch_name');
            $table->dropColumn('bank_routing_number');
            $table->dropColumn('status');
            $table->dropColumn('verified');
            $table->dropColumn('biometric_verified');
            $table->dropColumn('biometric_verification_type');
        });
    }
};

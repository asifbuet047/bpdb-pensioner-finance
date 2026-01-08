<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('clienttransid', 25)->unique();
            $table->string('server_reference_code')->nullable();
            $table->string('operatortransid')->nullable();
            $table->enum('type', ['single', 'bulk']);
            $table->string('cli')->nullable();
            $table->text('message');
            $table->json('msisdn');
            $table->string('status_code')->nullable();
            $table->string('error_description')->nullable();
            $table->enum('delivery_status', ['pending', 'delivered', 'undelivered'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
};

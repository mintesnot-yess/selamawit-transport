<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number', 100);
            $table->foreignId('bank_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            // $table->unsignedInteger('created_by');
            // $table->unsignedInteger('updated_by');
            $table->foreignId('created_by')->constrained('system_users')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('system_users')->cascadeOnDelete();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
};
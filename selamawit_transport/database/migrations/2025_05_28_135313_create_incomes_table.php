<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('amount', 12, 2);
            $table->string('attachment', 255);
            $table->date('received_date');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('system_users')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('system_users')->cascadeOnDelete();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('income');
    }
};
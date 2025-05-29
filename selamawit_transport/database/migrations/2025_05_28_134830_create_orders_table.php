<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('employee_id')->nullable();
            $table->unsignedInteger('vehicle_id');
            $table->unsignedBigInteger('loading_place')->nullable();
            $table->unsignedBigInteger('destination')->nullable();
            $table->unsignedInteger('load_type_id');
            $table->decimal('quintal', 10, 2)->nullable();
            $table->decimal('given_tariff', 12, 2)->nullable();
            $table->integer('sub_tariff');
            $table->timestamp('order_date')->useCurrent();
            $table->date('arrival_at_loading_site')->nullable();
            $table->date('loading_date')->nullable();
            $table->enum('current_condition', ['LOADED', 'OFFLOADED'])->nullable();
            $table->boolean('payment_collected')->default(false);
            $table->enum('status', ['PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            // $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('loading_place')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('destination')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('load_type_id')->references('id')->on('load_types')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('system_users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('system_users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
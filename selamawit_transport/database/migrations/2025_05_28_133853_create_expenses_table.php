<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('expense_type_id');
            $table->unsignedInteger('vehicle_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('from_account');
            $table->unsignedInteger('to_account');
            $table->unsignedInteger('to_bank')->nullable();
            $table->unsignedInteger('from_bank')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('paid_date');
            $table->text('remark')->nullable();
            $table->string('file', 255)->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();

            $table->foreign('expense_type_id')->references('id')->on('expense_types')->onDelete('cascade');
            // $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('from_account')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('to_account')->references('id')->on('bank_accounts')->onDelete('cascade');
            $table->foreign('to_bank')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('from_bank')->references('id')->on('banks')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('system_users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('system_users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
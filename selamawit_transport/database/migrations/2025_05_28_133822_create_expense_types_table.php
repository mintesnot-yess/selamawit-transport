<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expense_types', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 244);
            $table->enum('category', ['Private', 'Own', 'General', 'Vehicle', 'Employee']);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->date('created_at');
            $table->date('updated_at');

            $table->foreign('created_by')->references('id')->on('system_users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('system_users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense_types');
    }
};
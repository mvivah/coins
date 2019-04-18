<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('task_id')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('serviceline_id')->nullable();
            $table->string('activity_date')->nullable();
            $table->string('duration')->nullable();
            $table->longText('activity_description')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('serviceline_id')->references('id')->on('servicelines');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timesheets');
    }
}

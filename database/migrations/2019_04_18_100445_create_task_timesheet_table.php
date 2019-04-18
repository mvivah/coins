<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_timesheet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('timesheet_id')->unsigned();
            $table->string('task_id');
            $table->foreign('timesheet_id')->references('id')->on('timesheets');
            $table->foreign('task_id')->references('id')->on('tasks');
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
        Schema::dropIfExists('task_timesheet');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_id');
            $table->string('user_id');
            $table->string('associate_id')->nullable();
            $table->string('task_status')->default('Not Started');
            $table->string('updated_by')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('associate_id')->references('id')->on('associates');
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
        Schema::dropIfExists('task_users');
    }
}

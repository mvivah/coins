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
            $table->string('beneficiary');
            $table->string('serviceline_id');
            $table->string('opportunity_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('activity_date');
            $table->string('duration');
            $table->longText('activity_description');
            $table->foreign('serviceline_id')->references('id')->on('servicelines');
            $table->foreign('opportunity_id')->references('id')->on('opportunities');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
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

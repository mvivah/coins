<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id')->nullable();
            $table->string('opportunity_id')->nullable();
            $table->string('deliverable_name');
            $table->string('deliverable_status');
            $table->string('deliverable_completion');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('opportunity_id')->references('id')->on('opportunities');
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
        Schema::dropIfExists('deliverables');
    }
}

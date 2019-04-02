<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('opportunity_id');
            $table->String('initiation_date')->nullable();
            $table->String('completion_date')->nullable();
            $table->String('project_stage')->nullable();
            $table->String('project_status')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();

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
        Schema::dropIfExists('projects');
    }
}

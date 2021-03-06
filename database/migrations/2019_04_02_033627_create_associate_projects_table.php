<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associate_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id');
            $table->string('associate_id');
            $table->boolean('project_manager')->default(0);
            $table->boolean('availability')->default(0);
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('associate_projects');
    }
}

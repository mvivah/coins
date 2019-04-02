<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('associate_id')->nullable();
            $table->string('opportunity_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('document_url');
            $table->string('description')->nullable();
            $table->string('created_by');

            $table->foreign('associate_id')->references('id')->on('associates');
            $table->foreign('opportunity_id')->references('id')->on('opportunities');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('documents');
    }
}

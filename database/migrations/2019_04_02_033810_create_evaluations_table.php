<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('evaluationable_id');
            $table->string('evaluationable_type');
            $table->longText('exceptional_tasks');
            $table->longText('results_achieved');
            $table->longText('challenges_faced');
            $table->longText('improvement_plans');
            $table->string('user_id');
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
        Schema::dropIfExists('evaluations');
    }
}

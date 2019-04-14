<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverableOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverable_opportunity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deliverable_id');
            $table->string('opportunity_id');
            $table->string('deliverable_completion');
            $table->string('deliverable_status');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deliverable_id')->references('id')->on('deliverables');
            $table->foreign('opportunity_id')->references('id')->on('opportunities');
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
        Schema::dropIfExists('deliverable_opportunities');
    }
}

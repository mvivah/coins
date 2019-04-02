<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('contact_id');
            $table->integer('om_number');
            $table->string('opportunity_name');
            $table->string('country');
            $table->string('funder');
            $table->string('type');
            $table->string('sales_stage');
            $table->double('revenue');
            $table->string('lead_source');
            $table->date('internal_deadline');
            $table->date('external_deadline');
            $table->unsignedBigInteger('team_id');
            $table->integer('probability')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();            

            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('team_id')->references('id')->on('teams');
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
        Schema::dropIfExists('opportunities');
    }
}

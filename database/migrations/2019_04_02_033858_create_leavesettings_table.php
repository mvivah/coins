<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leavesettings', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('leave_type');
            $table->string('annual_lot')->nullable();
            $table->string('bookable_days')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();

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
        Schema::dropIfExists('leavesettings');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('user_id');
            $table->string('leavesetting_id');
            $table->string('start_date');
            $table->string('end_date');
            $table->longText('leave_detail');
            $table->integer('duration');
            $table->string('leave_status');
            $table->string('updated_by')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('leavesetting_id')->references('id')->on('leavesettings');
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
        Schema::dropIfExists('leaves');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loggers', function (Blueprint $table){

            $table->bigIncrements('id');
            $table->string('project_id');
            $table->string('user_id')->nullable();
            $table->string('associate_id')->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->string('availability')->default(0);
            $table->string('notes')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('associate_id')->references('id')->on('associates');
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
        Schema::dropIfExists('loggers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('staffId')->unique();
            $table->string('name');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobilePhone');
            $table->string('alternativePhone')->nullable();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('title_id');
            $table->unsignedBigInteger('role_id');
            $table->string('reportsTo');
            $table->string('userStatus');
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('lastLogin')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('title_id')->references('id')->on('titles');
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}

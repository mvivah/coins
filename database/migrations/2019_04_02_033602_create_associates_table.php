<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('associate_name')->unique();
            $table->string('associate_gender');
            $table->string('associate_email')->unique();
            $table->string('associate_country');
            $table->string('associate_phone');
            $table->string('associate_phone1')->nullable();
            $table->date('date_enrolled')->nullable();
            $table->string('expertise_id');
            $table->unsignedBigInteger('specialization_id');
            $table->string('associate_experience');
            $table->string('created_by');
            $table->string('updated_by')->nullable();

            $table->foreign('expertise_id')->references('id')->on('expertises');
            $table->foreign('specialization_id')->references('id')->on('specializations');
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
        Schema::dropIfExists('associates');
    }
}

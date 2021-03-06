<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->tinyInteger('correct_answer', 1)->default('0');
            $table->enum('user_answer', ['1', '2'])->nullable();
            $table->unsignedbigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedbigInteger('imageA_id');
            $table->foreign('imageA_id')->references('id')->on('images');
            $table->unsignedbigInteger('imageB_id');
            $table->foreign('imageB_id')->references('id')->on('images');
            $table->enum('state', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
}

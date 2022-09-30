<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporadas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('liga1_id')->nullable();
            $table->integer('liga2_id')->nullable();
            $table->integer('liga3_id')->nullable();
            $table->integer('copa1_id')->nullable();
            $table->integer('copa2_id')->nullable();
            $table->integer('artilheiro_liga_id')->nullable();
            $table->integer('artilheiro_copa_id')->nullable();
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
        Schema::drop('temporadas');
    }
}

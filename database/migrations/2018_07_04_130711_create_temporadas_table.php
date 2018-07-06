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
            $table->integer('liga1_id');
            $table->integer('liga2_id');
            $table->integer('liga3_id');
            $table->integer('copa1_id');
            $table->integer('copa2_id');
            $table->string('artilheiro_liga');
            $table->string('artilheiro_copa');
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

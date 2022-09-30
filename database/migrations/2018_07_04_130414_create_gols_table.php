<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gols', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade');
            $table->integer('time_id');
            $table->integer('partida_id');
            $table->integer('jogador_id');
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
        Schema::drop('gols');
    }
}

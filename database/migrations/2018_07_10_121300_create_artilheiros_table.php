<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtilheirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artilheiros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('campeonato');
            $table->string('jogador');
            $table->integer('temporada_id');
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
        Schema::drop('artilheiros');
    }
}

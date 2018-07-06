<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partidas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('campeonato');
            $table->integer('rodada');
            $table-> integer('temporada');
            $table->integer('time1_id');
            $table->integer('time2_id');
            $table->integer('resultado1');
            $table->integer('resultado2');
            $table->integer('penalti1');
            $table->integer('penalti2');
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
		Schema::drop('partidas');
	}

}

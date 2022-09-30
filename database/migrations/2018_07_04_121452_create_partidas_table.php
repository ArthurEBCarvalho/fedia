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
            $table->integer('temporada_id');
            $table->integer('time1_id')->nullable();
            $table->integer('time2_id')->nullable();
            $table->integer('resultado1')->nullable();
            $table->integer('resultado2')->nullable();
            $table->integer('penalti1')->nullable();
            $table->integer('penalti2')->nullable();
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

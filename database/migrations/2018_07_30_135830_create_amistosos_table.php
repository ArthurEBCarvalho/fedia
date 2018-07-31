<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmistososTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('amistosos', function(Blueprint $table) {
            $table->increments('id');
            $table-> integer('temporada');
            $table->integer('time11_id');
            $table->integer('time12_id');
            $table->integer('time21_id');
            $table->integer('time22_id');
            $table->integer('resultado1');
            $table->integer('resultado2');
            $table->integer('penalti1');
            $table->integer('penalti2');
            $table->decimal('valor', 18, 2);
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
		Schema::drop('amistosos');
	}

}

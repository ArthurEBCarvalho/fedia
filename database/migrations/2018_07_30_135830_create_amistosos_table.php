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
            $table->integer('temporada_id');
            $table->integer('time11_id')->nullable();
            $table->integer('time12_id')->nullable();
            $table->integer('time21_id')->nullable();
            $table->integer('time22_id')->nullable();
            $table->integer('resultado1')->nullable();
            $table->integer('resultado2')->nullable();
            $table->integer('penalti1')->nullable();
            $table->integer('penalti2')->nullable();
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

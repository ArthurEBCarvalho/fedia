<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transferencias', function(Blueprint $table) {
            $table->increments('id');
            $table->string('jogador');
            $table->decimal('valor', 10, 2);
            $table->integer('time1_id');
            $table->integer('time2_id');
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
		Schema::drop('transferencias');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('financeiros', function(Blueprint $table) {
            $table->increments('id');
            $table->decimal('valor',18,2);
            $table->tinyInteger('operacao');
            $table->string('descricao');
            $table->integer('time_id');
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
		Schema::drop('financeiros');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddElencosToJogadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogadors', function (Blueprint $table) {
            // $table->string('posicoes');
            // $table->integer('idade');
            // $table->integer('overall');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jogadors', function (Blueprint $table) {
            //
        });
    }
}

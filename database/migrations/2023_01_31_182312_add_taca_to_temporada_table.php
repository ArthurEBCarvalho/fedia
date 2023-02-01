<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTacaToTemporadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporadas', function (Blueprint $table) {
            $table->integer('taca1_id')->nullable();
            $table->integer('taca2_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporadas', function (Blueprint $table) {
            //
        });
    }
}

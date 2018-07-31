<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableFromAmistososTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amistosos', function (Blueprint $table) {
            $table->integer('time12_id')->nullable()->change();
            $table->integer('time22_id')->nullable()->change();
            $table->integer('resultado1')->nullable()->change();
            $table->integer('resultado2')->nullable()->change();
            $table->integer('penalti1')->nullable()->change();
            $table->integer('penalti2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amistosos', function (Blueprint $table) {
            //
        });
    }
}

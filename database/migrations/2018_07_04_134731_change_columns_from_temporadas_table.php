<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsFromTemporadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporadas', function (Blueprint $table) {
            $table->integer('liga1_id')->nullable()->change();
            $table->integer('liga2_id')->nullable()->change();
            $table->integer('liga3_id')->nullable()->change();
            $table->integer('copa1_id')->nullable()->change();
            $table->integer('copa2_id')->nullable()->change();
            $table->string('artilheiro_liga')->nullable()->change();
            $table->string('artilheiro_copa')->nullable()->change();
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

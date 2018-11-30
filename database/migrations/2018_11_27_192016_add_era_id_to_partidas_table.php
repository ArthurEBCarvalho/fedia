<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEraIdToPartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partidas', function (Blueprint $table) {
            $table->renameColumn('temporada', 'temporada_id');
        });
        Schema::table('amistosos', function (Blueprint $table) {
            $table->renameColumn('temporada', 'temporada_id');
        });
        Schema::table('cartaos', function (Blueprint $table) {
            $table->renameColumn('temporada', 'temporada_id');
        });
        Schema::table('lesaos', function (Blueprint $table) {
            $table->renameColumn('temporada', 'temporada_id');
        });
        Schema::table('gols', function (Blueprint $table) {
            $table->renameColumn('temporada', 'temporada_id');
        });
        Schema::table('transferencias', function (Blueprint $table) {
            $table->integer('era_id')->default(1);
        });
        Schema::table('temporadas', function (Blueprint $table) {
            $table->integer('era_id')->default(1);
        });
        Schema::table('times', function (Blueprint $table) {
            $table->integer('era_id')->default(1);
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partidas', function (Blueprint $table) {
            //
        });
    }
}

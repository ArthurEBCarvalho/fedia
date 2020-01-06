<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeArtilheiros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artilheiros', function (Blueprint $table) {
            $table->string('jogador_id')->change();
            $table->renameColumn('jogador_id', 'jogador');
        });

        Schema::table('temporadas', function (Blueprint $table) {
            $table->string('mvp_id')->change();
            $table->renameColumn('mvp_id', 'mvp');
        });

        foreach (App\Artilheiro::get() as $value) {
            $nome = App\Jogador::findOrFail($value->jogador)->nome;
            $value->jogador = $nome;
            $value->save();
        }

        foreach (App\Temporada::get() as $value) {
            if(is_null($value->mvp)) continue;
            $nome = App\Jogador::findOrFail($value->mvp)->nome;
            $value->mvp = $nome;
            $value->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

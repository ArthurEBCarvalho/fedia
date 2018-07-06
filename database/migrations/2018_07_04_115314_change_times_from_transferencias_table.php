<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTimesFromTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencias', function (Blueprint $table) {
            $table->renameColumn('time1_id', 'time1');
            $table->renameColumn('time2_id', 'time2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transferencias', function (Blueprint $table) {
            //
        });
    }
}

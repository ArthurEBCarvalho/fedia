<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTimeFromAmistososTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amistosos', function (Blueprint $table) {
            $table->integer('time11_id')->nullable()->change();
            $table->integer('time21_id')->nullable()->change();
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

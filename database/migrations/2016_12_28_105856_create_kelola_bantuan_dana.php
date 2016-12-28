<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelolaBantuanDana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bantuans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pengajuan')->unsigned();
            $table->bigInteger('jumlah_dana');


            $table->foreign('id_pengajuan')->references('id')->on('pengajuans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bantuans');

        Schema::table('bantuans', function (Blueprint $table) {
            $table->dropForeign('id_pengajuan');
        });
    }
}

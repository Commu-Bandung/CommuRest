<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelolaKerjasama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kerjasamas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pengajuan')->unsigned();
            $table->string('produk');
            $table->bigInteger('jumlah');

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
        Schema::dropIfExists('kerjasamas');

        Schema::table('kerjasamas', function (Blueprint $table) {
            $table->dropForeign('id_pengajuan');
        });
    }
}

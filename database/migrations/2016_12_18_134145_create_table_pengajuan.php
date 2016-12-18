<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePengajuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_anggota')->unsigned();
            $table->string('proposal');
            $table->enum('status_valid', ['belum','terima','tolak']);
            $table->enum('status_rev', ['belum','terima','tolak']);
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('anggotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->dropForeign('pengajuans_id_anggota_foreign');
        });
        Schema::dropIfExists('pengajuan');
    }
}

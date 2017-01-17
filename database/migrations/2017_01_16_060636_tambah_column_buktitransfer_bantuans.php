<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahColumnBuktitransferBantuans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bantuans', function (Blueprint $table) {
            $table->string('bukti')->after('jumlah_dana');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bantuans', function (Blueprint $table) {
            $table->dropColumn('jumlah_dana');
        });
    }
}

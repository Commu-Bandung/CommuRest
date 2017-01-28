<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdperusahaanOnreviewproposals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviewproposals', function (Blueprint $table) {
            $table->integer('id_perusahaan')->unsigned();

            $table->foreign('id_perusahaan')
                  ->references('id')->on('perusahaans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviewproposals', function (Blueprint $table) {
            $table->dropForeign(['id_perusahaan']);            
        });
    }
}

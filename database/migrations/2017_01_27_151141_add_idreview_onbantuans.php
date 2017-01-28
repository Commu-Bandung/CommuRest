<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdreviewOnbantuans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bantuans', function (Blueprint $table) {
            $table->integer('id_review')->unsigned();

            $table->foreign('id_review')
                  ->references('id')
                  ->on('reviewproposals');
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
            $table->dropForeign(['id_review']);
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableReviewProposal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewproposals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pengajuan')->unsigned();
            $table->enum('status',['tolak','terima']);

            $table->foreign('id_pengajuan')
                  ->references('id')->on('pengajuans')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewproposals');
        Schema::table('reviewproposals',function (Blueprint $table) {
            $table->dropForeign(['id_pengajuan']);
        });
    }
}

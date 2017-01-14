<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahTableSocialProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_proviers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('provider_id');
            $table->string('provider');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('anggotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_proviers', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
        Schema::dropIfExists('social_proviers');
    }
}

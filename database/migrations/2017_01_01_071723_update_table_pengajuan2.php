<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablePengajuan2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->enum('kategori',[
                                'teknologi','menejemen','language and culture','music','fashion & beuty','lain-lain'
                                ])
                                ->default('lain-lain');
            $table->string('deskripsi')
                                ->after('kategori');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['kategori','deskripsi']);
        });
    }
}

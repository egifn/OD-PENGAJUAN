<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('kode_perusahaan',5);
            $table->string('nama_perusahaan');
            $table->timestamps();
            $table->primary('kode_perusahaan'); /* SET PrimaryKey */
        });

        Schema::table('depos', function($table){
            $table->foreign('kode_perusahaan')
                ->references('kode_perusahaan')
                ->on('perusahaans')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        schema::table('rekenings',function($table){
            $table->foreign('kode_perusahaan')
                ->references('kode_perusahaan')
                ->on('perusahaans')
                ->onUpdate('cascade')
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
        Schema::dropIfExists('perusahaans');
    }
}

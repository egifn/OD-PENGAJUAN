<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('kode_depo',5);
            $table->string('nama_depo');
            $table->string('alias');
            $table->string('kode_perusahaan');
            $table->timestamps();
            $table->primary('kode_depo'); /* SET PrimaryKey */
        });

        Schema::table('rekenings',function (Blueprint $table) {
            $table->foreign('kode_depo')
                ->references('kode_depo')
                ->on('depos')
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
        Schema::dropIfExists('depos');
    }
}

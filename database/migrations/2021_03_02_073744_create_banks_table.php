<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('kode_bank');
            $table->string('nama_bank');
            $table->timestamps();
            $table->primary('kode_bank');
        });

        Schema::table('rekenings', function (Blueprint $table) {
            $table->foreign('kode_bank')
                ->references('kode_bank')
                ->on('banks')
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
        Schema::dropIfExists('banks');
    }
}

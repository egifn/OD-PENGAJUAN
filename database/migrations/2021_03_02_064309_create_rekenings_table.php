<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekenings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('norek',15);
            $table->integer('kode_bank');
            $table->string('kode_perusahaan');
            $table->string('kode_depo');
            $table->string('kode_user');
            $table->timestamps();
            $table->primary('norek');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekenings');
    }
}

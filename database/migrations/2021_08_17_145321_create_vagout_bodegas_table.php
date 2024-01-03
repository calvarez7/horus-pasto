<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVagoutBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vagout_bodegas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('consecutivo_factura')->nullable();
            $table->bigInteger('estado_id')->default('1')->unsigned()->index();
            $table->foreign('estado_id')->references('id')->on('Estados');
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
        Schema::dropIfExists('vagout_bodegas');
    }
}

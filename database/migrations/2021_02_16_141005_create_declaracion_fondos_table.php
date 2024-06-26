<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclaracionFondosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declaracion_fondos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sarlafs_id')->unsigned()->nullable()->index();
            $table->foreign('sarlafs_id')->references('id')->on('sarlafts');
            $table->string('declaracion')->nullable();
            $table->bigInteger('estado_id')->default('1')->unsigned()->index();
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('declaracion_fondos');
    }
}

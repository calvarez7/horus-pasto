<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtrosFarmacologicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otros_farmacologicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('usuario_id')->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('Users');
            $table->bigInteger('paciente_id')->nullable()->unsigned()->index();
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->bigInteger('codesumi_id')->nullable()->unsigned()->index();
            $table->foreign('codesumi_id')->references('id')->on('codesumis');
            $table->string('intervencion_dirigida')->nullable();
            $table->string('intervencion_principal')->nullable();
            $table->string('prmevidenciado')->nullable();
            $table->string('reaccion')->nullable();
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
        Schema::dropIfExists('otros_farmacologicas');
    }
}

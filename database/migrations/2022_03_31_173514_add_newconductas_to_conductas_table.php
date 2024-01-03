<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewconductasToConductasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conductas', function (Blueprint $table) {
            $table->bigInteger('usuario_id')->nullable()->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('Users');
            $table->bigInteger('paciente_id')->nullable()->unsigned()->index();
            $table->foreign('paciente_id')->references('id')->on('pacientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conductas', function (Blueprint $table) {
            $table->bigInteger('usuario_id')->nullable()->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('Users');
            $table->bigInteger('paciente_id')->nullable()->unsigned()->index();
            $table->foreign('paciente_id')->references('id')->on('pacientes');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadificacionRCVComponentToProcesoHistoriaIntegrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proceso_historia_integrals', function (Blueprint $table) {
            $table->boolean('EstadificacionRCVComponent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proceso_historia_integrals', function (Blueprint $table) {
            $table->boolean('EstadificacionRCVComponent')->nullable();
        });
    }
}

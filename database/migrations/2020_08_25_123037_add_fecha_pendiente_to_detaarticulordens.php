<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechaPendienteToDetaarticulordens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detaarticulordens', function (Blueprint $table) {
            $table->timestamp('fecha_pendiente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detaarticulordens', function (Blueprint $table) {
            $table->timestamp('fecha_pendiente')->nullable();
        });
    }
}

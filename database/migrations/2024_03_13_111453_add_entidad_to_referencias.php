<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntidadToReferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referencias', function (Blueprint $table) {
            $table->foreignId('entidad_id')->nullable()->constrained('entidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referencias', function (Blueprint $table) {
            $table->foreignId('entidad_id')->nullable()->constrained('entidades');
        });
    }
}

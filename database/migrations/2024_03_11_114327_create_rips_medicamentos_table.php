<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRipsMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rips_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rips_usuario_id')->nullable()->index();
            $table->foreign('rips_usuario_id')->references('id')->on('rips_usuarios');
            $table->string('cantidadMedicamento')->nullable();
            $table->string('codDiagnosticoPrincipal')->nullable();
            $table->string('codDiagnosticoRelacionado')->nullable();
            $table->string('codPrestador')->nullable();
            $table->string('codTecnologiaSalud')->nullable();
            $table->string('concentracionMedicamento')->nullable();
            $table->string('conceptoRecaudo')->nullable();
            $table->string('consecutivo')->nullable();
            $table->string('diasTratamiento')->nullable();
            $table->string('fechaDispensAdmon')->nullable();
            $table->string('formaFarmaceutica')->nullable();
            $table->string('idMIPRES')->nullable();
            $table->string('nomTecnologiaSalud')->nullable();
            $table->string('numAutorizacion')->nullable();
            $table->string('numDocumentoIdentificacion')->nullable();
            $table->string('numFEVPagoModerador')->nullable();
            $table->string('tipoDocumentoIdentificacion')->nullable();
            $table->string('tipoMedicamento')->nullable();
            $table->string('unidadMedida')->nullable();
            $table->string('unidadMinDispensa')->nullable();
            $table->string('valorPagoModerador')->nullable();
            $table->string('vrServicio')->nullable();
            $table->string('vrUnitMedicamento')->nullable();
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
        Schema::dropIfExists('rips_medicamentos');
    }
}

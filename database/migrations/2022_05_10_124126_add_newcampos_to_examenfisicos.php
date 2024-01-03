<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewcamposToExamenfisicos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examenfisicos', function (Blueprint $table) {
            $table->string('cabeza')->nullable();
            $table->boolean('checkboxCcc')->nullable();
            $table->string('cara')->nullable();
            $table->string('Ojos')->nullable();
            $table->string('Selccc')->nullable();
            $table->string('AgudezavisualDer')->nullable();
            $table->string('AgudezavisualIzq')->nullable();
            $table->string('Conjuntiva')->nullable();
            $table->string('Esclera')->nullable();
            $table->string('OjosfondojosAnt')->nullable();
            $table->string('OjosfondojosPost')->nullable();
            $table->string('Nariz')->nullable();
            $table->string('Tabique')->nullable();
            $table->string('Cornetes')->nullable();
            $table->string('Oidos')->nullable();
            $table->string('AuricularDer')->nullable();
            $table->string('AuricularIzq')->nullable();
            $table->string('ConductoDer')->nullable();
            $table->string('MembranaTim')->nullable();
            $table->string('integra')->nullable();
            $table->string('perforacion')->nullable();
            $table->string('TubosVen')->nullable();
            $table->string('Maxilar')->nullable();
            $table->string('LabiosComisura')->nullable();
            $table->string('MejillaCarrillo')->nullable();
            $table->string('CavidadOral')->nullable();
            $table->string('ArticulaciónTemporo')->nullable();
            $table->string('EstructurasDentales')->nullable();
            $table->boolean('checkboxTorax')->nullable();
            $table->string('Torax')->nullable();
            $table->boolean('checkboxDesTorax')->nullable();
            $table->string('Mamas')->nullable();
            $table->string('Pectorales')->nullable();
            $table->string('RejaCostal')->nullable();
            $table->boolean('checkboxDesToraxPos')->nullable();
            $table->string('RejaCostalPos')->nullable();
            $table->string('DesvCol')->nullable();
            $table->boolean('checkboxCardioPulmonar')->nullable();
            $table->string('Pulmones')->nullable();
            $table->string('Cardiacos')->nullable();
            $table->boolean('checkboxAbdomen')->nullable();
            $table->string('AlturaUterina')->nullable();
            $table->string('ActividadUterina')->nullable();
            $table->string('FrecuenciaCardiacaFetal')->nullable();
            $table->string('movimientosFetales')->nullable();
            $table->string('RuidosPlacentarios')->nullable();
            $table->boolean('checkboxManiobra')->nullable();
            $table->string('PresentacionFetal')->nullable();
            $table->integer('NumFetos')->nullable();
            $table->string('PosUtero')->nullable();
            $table->string('Tacto')->nullable();
            $table->boolean('checkboxGenitoUrinario')->nullable();
            $table->string('Maculino')->nullable();
            $table->string('Testiculos')->nullable();
            $table->string('Escroto')->nullable();
            $table->string('Prepucio')->nullable();
            $table->string('Cordon')->nullable();
            $table->string('TactoRectalHom')->nullable();
            $table->string('Femenino')->nullable();
            $table->string('Especuloscopia')->nullable();
            $table->string('TactoVag')->nullable();
            $table->string('Involucion')->nullable();
            $table->string('SangradoUter')->nullable();
            $table->string('ExpulTapon')->nullable();
            $table->string('Dilatacioncuello')->nullable();
            $table->string('Borramiento')->nullable();
            $table->string('Estacion')->nullable();
            $table->string('loquios')->nullable();
            $table->string('Tactorecfem')->nullable();
            $table->string('TemTono')->nullable();
            $table->boolean('checkboxPerine')->nullable();
            $table->string('DesgarroPerine')->nullable();
            $table->string('Episiorragia')->nullable();
            $table->boolean('checkboxExtremidades')->nullable();
            $table->boolean('checkboxSistemaNervioso')->nullable();
            $table->string('SistemaNervioso')->nullable();
            $table->string('ParesCraneales')->nullable();
            $table->string('EvaluacionMarcha')->nullable();
            $table->string('EvaluacionTonoMuscular')->nullable();
            $table->string('EvaluacionFuerza')->nullable();
            $table->string('EvaluacionEsfera')->nullable();
            $table->boolean('checkboxPielFaneras')->nullable();
            $table->string('PielFaneras')->nullable();
            $table->boolean('checkboxSistemaOsteo')->nullable();
            $table->string('SistemaOsteo')->nullable();
            $table->string('Cuello')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examenfisicos', function (Blueprint $table) {
            $table->string('cabeza')->nullable();
            $table->boolean('checkboxCcc')->nullable();
            $table->string('cabeza')->nullable();
            $table->string('Ojos')->nullable();
            $table->string('Selccc')->nullable();
            $table->string('AgudezavisualDer')->nullable();
            $table->string('AgudezavisualIzq')->nullable();
            $table->string('Conjuntiva')->nullable();
            $table->string('Esclera')->nullable();
            $table->string('OjosfondojosAnt')->nullable();
            $table->string('OjosfondojosPost')->nullable();
            $table->string('Nariz')->nullable();
            $table->string('Tabique')->nullable();
            $table->string('Cornetes')->nullable();
            $table->string('Oidos')->nullable();
            $table->string('AuricularDer')->nullable();
            $table->string('AuricularIzq')->nullable();
            $table->string('ConductoDer')->nullable();
            $table->string('MembranaTim')->nullable();
            $table->string('integra')->nullable();
            $table->string('perforacion')->nullable();
            $table->string('TubosVen')->nullable();
            $table->string('Maxilar')->nullable();
            $table->string('LabiosComisura')->nullable();
            $table->string('MejillaCarrillo')->nullable();
            $table->string('CavidadOral')->nullable();
            $table->string('ArticulaciónTemporo')->nullable();
            $table->string('EstructurasDentales')->nullable();
            $table->boolean('checkboxTorax')->nullable();
            $table->string('Torax')->nullable();
            $table->boolean('checkboxDesTorax')->nullable();
            $table->string('Mamas')->nullable();
            $table->string('Pectorales')->nullable();
            $table->string('RejaCostal')->nullable();
            $table->boolean('checkboxDesToraxPos')->nullable();
            $table->string('RejaCostalPos')->nullable();
            $table->string('DesvCol')->nullable();
            $table->boolean('checkboxCardioPulmonar')->nullable();
            $table->string('Pulmones')->nullable();
            $table->string('Cardiacos')->nullable();
            $table->boolean('checkboxAbdomen')->nullable();
            $table->string('AlturaUterina')->nullable();
            $table->string('ActividadUterina')->nullable();
            $table->string('FrecuenciaCardiacaFetal')->nullable();
            $table->string('movimientosFetales')->nullable();
            $table->string('RuidosPlacentarios')->nullable();
            $table->boolean('checkboxManiobra')->nullable();
            $table->string('PresentacionFetal')->nullable();
            $table->integer('NumFetos')->nullable();
            $table->string('PosUtero')->nullable();
            $table->string('Tacto')->nullable();
            $table->boolean('checkboxGenitoUrinario')->nullable();
            $table->string('Maculino')->nullable();
            $table->string('Testiculos')->nullable();
            $table->string('Escroto')->nullable();
            $table->string('Prepucio')->nullable();
            $table->string('Cordon')->nullable();
            $table->string('TactoRectalHom')->nullable();
            $table->string('Femenino')->nullable();
            $table->string('Especuloscopia')->nullable();
            $table->string('TactoVag')->nullable();
            $table->string('Involucion')->nullable();
            $table->string('SangradoUter')->nullable();
            $table->string('ExpulTapon')->nullable();
            $table->string('Dilatacioncuello')->nullable();
            $table->string('Borramiento')->nullable();
            $table->string('Estacion')->nullable();
            $table->string('loquios')->nullable();
            $table->string('Tactorecfem')->nullable();
            $table->string('TemTono')->nullable();
            $table->boolean('checkboxPerine')->nullable();
            $table->string('DesgarroPerine')->nullable();
            $table->string('Episiorragia')->nullable();
            $table->boolean('checkboxExtremidades')->nullable();
            $table->boolean('checkboxSistemaNervioso')->nullable();
            $table->string('SistemaNervioso')->nullable();
            $table->string('ParesCraneales')->nullable();
            $table->string('EvaluacionMarcha')->nullable();
            $table->string('EvaluacionTonoMuscular')->nullable();
            $table->string('EvaluacionFuerza')->nullable();
            $table->string('EvaluacionEsfera')->nullable();
            $table->boolean('checkboxPielFaneras')->nullable();
            $table->string('PielFaneras')->nullable();
            $table->boolean('checkboxSistemaOsteo')->nullable();
            $table->string('SistemaOsteo')->nullable();
            $table->string('Cuello')->nullable();
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacienteantecedentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacienteantecedentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('checkboxOtras_enfermedades')->nullable();
            $table->string('checkboxasma')->nullable();
            $table->string('asmaPresente')->nullable();
            $table->string('asmaTipo')->nullable();
            $table->string('asmaTratamiento')->nullable();
            $table->string('asmaFecha')->nullable();
            $table->string('checkboxepoc')->nullable();
            $table->string('epocPresente')->nullable();
            $table->string('epocTipo')->nullable();
            $table->string('epocTratamiento')->nullable();
            $table->string('epocFecha')->nullable();
            $table->string('checkboxdiabetes')->nullable();
            $table->string('diabetesPresente')->nullable();
            $table->string('diabetesTipo')->nullable();
            $table->string('diabetesTratamiento')->nullable();
            $table->string('diabetesFecha')->nullable();
            $table->string('checkboxtuberculosis')->nullable();
            $table->string('tuberculosisPresente')->nullable();
            $table->string('tuberculosisTipo')->nullable();
            $table->string('tuberculosisTratamiento')->nullable();
            $table->string('tuberculosisFecha')->nullable();
            $table->string('checkboxCancer')->nullable();
            $table->string('checkboxCancerPresente')->nullable();
            $table->string('checkboxCancerTipo')->nullable();
            $table->string('checkboxCancerTratamiento')->nullable();
            $table->string('checkboxCancerFecha')->nullable();
            $table->string('checkboxhipertension_arterial')->nullable();
            $table->string('hipertension_arterialPresente')->nullable();
            $table->string('hipertension_arterialTipo')->nullable();
            $table->string('hipertension_arterialTratamiento')->nullable();
            $table->string('hipertension_arterialFecha')->nullable();
            $table->string('checkboxenfermedad_renal_cronica')->nullable();
            $table->string('enfermedad_renal_cronicaPresente')->nullable();
            $table->string('enfermedad_renal_cronicaTipo')->nullable();
            $table->string('enfermedad_renal_cronicaTratamiento')->nullable();
            $table->string('enfermedad_renal_cronicaFecha')->nullable();
            $table->string('checkboxenfermedad_cerebrovascular')->nullable();
            $table->string('enfermedad_cerebrovascularPresente')->nullable();
            $table->string('enfermedad_cerebrovascularTipo')->nullable();
            $table->string('enfermedad_cerebrovascularTratamiento')->nullable();
            $table->string('enfermedad_cerebrovascularFecha')->nullable();
            $table->string('checkboxenfermedad_genetica_congenita_multiple')->nullable();
            $table->string('enfermedad_genetica_congenita_multiplePresente')->nullable();
            $table->string('enfermedad_genetica_congenita_multipleTipo')->nullable();
            $table->string('enfermedad_genetica_congenita_multipleTratamiento')->nullable();
            $table->string('enfermedad_genetica_congenita_multipleFecha')->nullable();
            $table->string('checkboxenfermedad_anemica')->nullable();
            $table->string('enfermedad_anemicaPresente')->nullable();
            $table->string('enfermedad_anemicaTipo')->nullable();
            $table->string('enfermedad_anemicaTratamiento')->nullable();
            $table->string('enfermedad_anemicaFecha')->nullable();
            $table->string('checkboxenfermedades_trasmision_sexual')->nullable();
            $table->string('enfermedades_trasmision_sexualPresente')->nullable();
            $table->string('enfermedades_trasmision_sexualTipo')->nullable();
            $table->string('enfermedades_trasmision_sexualTratamiento')->nullable();
            $table->string('enfermedades_trasmision_sexualFecha')->nullable();
            $table->string('checkboxsindrome_convulsivo')->nullable();
            $table->string('sindrome_convulsivoPresente')->nullable();
            $table->string('sindrome_convulsivoTipo')->nullable();
            $table->string('sindrome_convulsivoTratamiento')->nullable();
            $table->string('sindrome_convulsivoFecha')->nullable();
            $table->string('checkboxcovid')->nullable();
            $table->string('covidPresente')->nullable();
            $table->string('covidTipo')->nullable();
            $table->string('covidTratamiento')->nullable();
            $table->string('covidFecha')->nullable();
            $table->string('checkboxenfermedad_arterial_oclusiva_cronica')->nullable();
            $table->string('enfermedad_arterial_oclusiva_cronicaPresente')->nullable();
            $table->string('enfermedad_arterial_oclusiva_cronicaTipo')->nullable();
            $table->string('enfermedad_arterial_oclusiva_cronicaTratamiento')->nullable();
            $table->string('enfermedad_arterial_oclusiva_cronicaFecha')->nullable();
            $table->string('checkboxtromboflevitis')->nullable();
            $table->string('tromboflevitisPresente')->nullable();
            $table->string('tromboflevitisTipo')->nullable();
            $table->string('tromboflevitisTratamiento')->nullable();
            $table->string('tromboflevitisFecha')->nullable();
            $table->string('checkboxotras_enfermedades_neurologicas')->nullable();
            $table->string('otras_enfermedades_neurologicasPresente')->nullable();
            $table->string('otras_enfermedades_neurologicasTipo')->nullable();
            $table->string('otras_enfermedades_neurologicasTratamiento')->nullable();
            $table->string('otras_enfermedades_neurologicasFecha')->nullable();
            $table->string('checkboxenfermedad_de_hansen')->nullable();
            $table->string('enfermedad_de_hansenPresente')->nullable();
            $table->string('enfermedad_de_hansenTipo')->nullable();
            $table->string('enfermedad_de_hansenTratamiento')->nullable();
            $table->string('enfermedad_de_hansenFecha')->nullable();
            $table->string('checkboxvih')->nullable();
            $table->string('vihPresente')->nullable();
            $table->string('vihTipo')->nullable();
            $table->string('vihTratamiento')->nullable();
            $table->string('vihFecha')->nullable();
            $table->string('checkboxenfermedad_cardiopatia_isquemica')->nullable();
            $table->string('enfermedad_cardiopatia_isquemicaPresente')->nullable();
            $table->string('enfermedad_cardiopatia_isquemicaTipo')->nullable();
            $table->string('enfermedad_cardiopatia_isquemicaTratamiento')->nullable();
            $table->string('enfermedad_cardiopatia_isquemicaFecha')->nullable();
            $table->string('checkboxmalnutricion')->nullable();
            $table->string('malnutricionPresente')->nullable();
            $table->string('malnutricionTipo')->nullable();
            $table->string('malnutricionTratamiento')->nullable();
            $table->string('malnutricionFecha')->nullable();
            $table->string('checkboxdislipidemia')->nullable();
            $table->string('dislipidemiaPresente')->nullable();
            $table->string('dislipidemiaTipo')->nullable();
            $table->string('dislipidemiaTratamiento')->nullable();
            $table->string('dislipidemiaFecha')->nullable();
            $table->string('checkboxhipotirodismo_congenito')->nullable();
            $table->string('hipotirodismo_congenitoPresente')->nullable();
            $table->string('hipotirodismo_congenitoTipo')->nullable();
            $table->string('hipotirodismo_congenitoTratamiento')->nullable();
            $table->string('hipotirodismo_congenitoFecha')->nullable();
            $table->string('checkboxenfermedad_artritis_reumatoide')->nullable();
            $table->string('enfermedad_artritis_reumatoidePresente')->nullable();
            $table->string('enfermedad_artritis_reumatoideTipo')->nullable();
            $table->string('enfermedad_artritis_reumatoideTratamiento')->nullable();
            $table->string('enfermedad_artritis_reumatoideFecha')->nullable();
            $table->string('checkboxenfermedad_cardiovascular')->nullable();
            $table->string('enfermedad_cardiovascularPresente')->nullable();
            $table->string('enfermedad_cardiovascularTipo')->nullable();
            $table->string('enfermedad_cardiovascularTratamiento')->nullable();
            $table->string('enfermedad_cardiovascularFecha')->nullable();
            $table->string('checkboxenfermedades_autoinmunes')->nullable();
            $table->string('enfermedades_autoinmunesPresente')->nullable();
            $table->string('enfermedades_autoinmunesTipo')->nullable();
            $table->string('enfermedades_autoinmunesTratamiento')->nullable();
            $table->string('enfermedades_autoinmunesFecha')->nullable();
            $table->string('checkboxenfermedad_acido_peptica')->nullable();
            $table->string('enfermedad_acido_pepticaPresente')->nullable();
            $table->string('enfermedad_acido_pepticaTipo')->nullable();
            $table->string('enfermedad_acido_pepticaTratamiento')->nullable();
            $table->string('enfermedad_acido_pepticaFecha')->nullable();
            $table->string('checkboxsindrome_de_apnea_hipoapnea_del_sueno')->nullable();
            $table->string('sindrome_de_apnea_hipoapnea_del_suenoPresente')->nullable();
            $table->string('sindrome_de_apnea_hipoapnea_del_suenoTipo')->nullable();
            $table->string('sindrome_de_apnea_hipoapnea_del_suenoTratamiento')->nullable();
            $table->string('sindrome_de_apnea_hipoapnea_del_suenoFecha')->nullable();
            $table->string('checkboxpatologia_perinatal_neonatal_significativa')->nullable();
            $table->string('patologia_perinatal_neonatal_significativaPresente')->nullable();
            $table->string('patologia_perinatal_neonatal_significativaTipo')->nullable();
            $table->string('patologia_perinatal_neonatal_significativaTratamiento')->nullable();
            $table->string('patologia_perinatal_neonatal_significativaFecha')->nullable();
            $table->string('checkboxhijo_de_madre_infeccion_gestacional_alto_riesgo')->nullable();
            $table->string('hijo_de_madre_infeccion_gestacional_alto_riesgoPresente')->nullable();
            $table->string('hijo_de_madre_infeccion_gestacional_alto_riesgoTipo')->nullable();
            $table->string('hijo_de_madre_infeccion_gestacional_alto_riesgoTratamiento')->nullable();
            $table->string('hijo_de_madre_infeccion_gestacional_alto_riesgoFecha')->nullable();
            $table->string('checkboxdermatitis_atopica')->nullable();
            $table->string('dermatitis_atopicaPresente')->nullable();
            $table->string('dermatitis_atopicaTipo')->nullable();
            $table->string('dermatitis_atopicaTratamiento')->nullable();
            $table->string('dermatitis_atopicaFecha')->nullable();
            $table->string('checkboxenfermedad_musculo_esqueleticas')->nullable();
            $table->string('enfermedad_musculo_esqueleticasPresente')->nullable();
            $table->string('enfermedad_musculo_esqueleticasTipo')->nullable();
            $table->string('enfermedad_musculo_esqueleticasTratamiento')->nullable();
            $table->string('enfermedad_musculo_esqueleticasFecha')->nullable();
            $table->string('checkboxhijo_de_madre_sospecha_depresion_pos_parto')->nullable();
            $table->string('hijo_de_madre_sospecha_depresion_pos_partoPresente')->nullable();
            $table->string('hijo_de_madre_sospecha_depresion_pos_partoTipo')->nullable();
            $table->string('hijo_de_madre_sospecha_depresion_pos_partoTratamiento')->nullable();
            $table->string('hijo_de_madre_sospecha_depresion_pos_partoFecha')->nullable();
            $table->string('checkboxhijo_de_madre_sospecha_consumo_de_spa')->nullable();
            $table->string('hijo_de_madre_sospecha_consumo_de_spaPresente')->nullable();
            $table->string('hijo_de_madre_sospecha_consumo_de_spaTipo')->nullable();
            $table->string('hijo_de_madre_sospecha_consumo_de_spaTratamiento')->nullable();
            $table->string('hijo_de_madre_sospecha_consumo_de_spaFecha')->nullable();
            $table->string('checkboxhijo_de_padre_enfermedad_mental')->nullable();
            $table->string('hijo_de_padre_enfermedad_mentalPresente')->nullable();
            $table->string('hijo_de_padre_enfermedad_mentalTipo')->nullable();
            $table->string('hijo_de_padre_enfermedad_mentalTratamiento')->nullable();
            $table->string('hijo_de_padre_enfermedad_mentalFecha')->nullable();
            $table->string('checkboxnino_acompanante_madre_privacion_libertad')->nullable();
            $table->string('nino_acompanante_madre_privacion_libertadPresente')->nullable();
            $table->string('nino_acompanante_madre_privacion_libertadTipo')->nullable();
            $table->string('nino_acompanante_madre_privacion_libertadTratamiento')->nullable();
            $table->string('nino_acompanante_madre_privacion_libertadFecha')->nullable();
            $table->bigInteger('paciente_id')->unsigned()->index();
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->bigInteger('citapaciente_id')->unsigned()->index();
            $table->foreign('citapaciente_id')->references('id')->on('cita_paciente');
            $table->bigInteger('usuario_id')->unsigned()->index();
            $table->foreign('usuario_id')->references('id')->on('Users');
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
        Schema::dropIfExists('pacienteantecedentes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
        });

        Schema::create('diagnosticos_mascotas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("diagnostico_id");
            $table->foreign("diagnostico_id")->references("id")->on("diagnosticos");

            $table->unsignedBigInteger("mascota_id");
            $table->foreign("mascota_id")->references("id")->on("mascotas");

            $table->unsignedBigInteger("historia_clinica_id");
            $table->foreign("historia_clinica_id")->references("id")->on("historias_clinicas");
            
            $table->string("estado"); // presuntivo - confirmado

        });

        Schema::create('examenes_auxiliares', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
        });

        Schema::create('examenes_auxiliares_mascotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("mascota_id");
            $table->foreign("mascota_id")->references("id")->on("mascotas");
            
            $table->unsignedBigInteger("examen_auxiliar_id");
            $table->foreign("examen_auxiliar_id")->references("id")->on("examenes_auxiliares");

            $table->unsignedBigInteger("historia_clinica_id");
            $table->foreign("historia_clinica_id")->references("id")->on("historias_clinicas");

            $table->string("indicaciones");
        });

        // Schema::create('historias_clinicas', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('idMascota'); 
        //     $table->timestamps();

        //     $table->foreign('idMascota')->references('id')->on('mascotas');
        // });

        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->longText("descripcion")->nullable()->after("idMascota");
            $table->string('temperatura')->nullable()->after("descripcion");
            $table->string('peso')->nullable()->after("temperatura");
            $table->string('presion_arterial')->nullable()->after("peso");
            $table->string('frecuencia_cardiaca')->nullable()->after("presion_arterial");
            $table->string('porcentaje_deshidratacion')->nullable()->after("frecuencia_cardiaca");
            $table->string('examen_tacto_rectal')->nullable()->after("porcentaje_deshidratacion");
            $table->string('frecuencia_respiratoria')->nullable()->after("examen_tacto_rectal");
            $table->string('tiempo_llenado_capilar')->nullable()->after("frecuencia_respiratoria");
            $table->longText("examen_clinico")->nullable()->after("tiempo_llenado_capilar");
            $table->boolean('conformidad_pago')->default(false)->after("examen_clinico");
            $table->boolean('documentacion_firmada')->default(false)->after("conformidad_pago");
            $table->boolean('riesgo_quirurgico')->default(false)->after("documentacion_firmada");
            $table->boolean('miccion')->nullable()->default(false)->after("riesgo_quirurgico");
            $table->boolean('deposicion')->nullable()->default(false)->after("miccion");
            $table->boolean('ayuno_previo')->nullable()->default(false)->after("deposicion");
            $table->longText("tratamiento")->nullable()->after("ayuno_previo");

        });

        Schema::create('tratamientos_mascotas', function (Blueprint $table) {
            // aca ingresa medicamentos, vacunas, antiparasitarios, antipulgas
            $table->id();
            $table->unsignedBigInteger("mascota_id");
            $table->foreign("mascota_id")->references("id")->on("mascotas");

            $table->unsignedBigInteger("producto_id");
            $table->foreign("producto_id")->references("id")->on("productos");
            $table->integer("cantidad");

            $table->unsignedBigInteger("categoria_id");
            $table->foreign("categoria_id")->references("id")->on("categorias");

            $table->unsignedBigInteger("historia_clinica_id");
            $table->foreign("historia_clinica_id")->references("id")->on("historias_clinicas");

            $table->string("indicaciones");
            $table->timestamps();
           
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //deshacer todo lo que se hizo en el metodo up

       
        Schema::dropIfExists('diagnosticos');
        Schema::dropIfExists('diagnosticos_mascotas');

      
        
        Schema::dropIfExists('examenes_auxiliares');
        Schema::dropIfExists('examenes_auxiliares_mascotas');
        

        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn("descripcion");
            $table->dropColumn("temperatura");
            $table->dropColumn("peso");
            $table->dropColumn("presion_arterial");
            $table->dropColumn("frecuencia_cardiaca");
            $table->dropColumn("porcentaje_deshidratacion");
            $table->dropColumn("examen_tacto_rectal");
            $table->dropColumn("frecuencia_respiratoria");
            $table->dropColumn("tiempo_llenado_capilar");
            $table->dropColumn("examen_clinico");
            $table->dropColumn("conformidad_pago");
            $table->dropColumn("documentacion_firmada");
            $table->dropColumn("riesgo_quirurgico");
            $table->dropColumn("miccion");
            $table->dropColumn("deposicion");
            $table->dropColumn("ayuno_previo");
            $table->dropColumn("tratamiento");
            

        });
       
      
    
        Schema::dropIfExists('tratamientos_mascotas');

    }
};

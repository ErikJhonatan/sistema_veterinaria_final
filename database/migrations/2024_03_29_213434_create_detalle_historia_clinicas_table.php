<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_historia_clinicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idHistoriaClinica');
            $table->unsignedBigInteger('idTipoHistoriaClinica');
            $table->string('motivo',200)->nullable();
            $table->string('descripcion',200)->nullable();
            $table->string('temperatura',200)->nullable();
            $table->string('frecuenciaCardiaca',200)->nullable();
            $table->string('frecuenciaRespiratoria',200)->nullable();
            $table->string('peso',200)->nullable();
            $table->string('dht',200)->nullable();
            $table->string('tlc',200)->nullable();
            $table->string('presionArterial',200)->nullable();
            $table->string('examenTactoRectal',200)->nullable();
            $table->string('examenClinico',200)->nullable();
            $table->string('Observaciones',200)->nullable();

            $table->timestamps();

            $table->foreign('idHistoriaClinica')->references('id')->on('historias_clinicas');;
            $table->foreign('idTipoHistoriaClinica')->references('id')->on('tipos_historias_clinicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_historia_clinicas');
    }
};

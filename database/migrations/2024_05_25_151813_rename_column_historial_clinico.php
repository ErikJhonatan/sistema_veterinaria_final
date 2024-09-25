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
        Schema::table('diagnosticos_mascotas', function (Blueprint $table) {
            $table->renameColumn('estado', 'observacion');
        });

        Schema::table('examenes_auxiliares_mascotas', function (Blueprint $table) {
            $table->renameColumn('indicaciones', 'observacion');
        });

        Schema::table('tratamientos_mascotas', function (Blueprint $table) {
            $table->renameColumn('indicaciones', 'observacion');
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');

            $table->unsignedBigInteger("tipo_historia_clinica_id");
            $table->foreign("tipo_historia_clinica_id")->references("id")->on("tipos_historias_clinicas");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnosticos_mascotas', function (Blueprint $table) {
            $table->renameColumn('observacion', 'estado');
        });

        Schema::table('examenes_auxiliares', function (Blueprint $table) {
            $table->renameColumn('observacion', 'indicaciones');
        });

        Schema::table('tratamientos_mascotas', function (Blueprint $table) {
            $table->renameColumn('observacion', 'indicaciones');
            $table->unsignedBigInteger("categoria_id");
            $table->dropForeign(['tipo_historia_clinica_id']);
            $table->dropColumn("tipo_historia_clinica_id");
        });
    }
};

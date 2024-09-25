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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->unsignedBigInteger("tipo_historia_clinica_id");
            $table->foreign("tipo_historia_clinica_id")->references("id")->on("tipos_historias_clinicas");
            $table->boolean("conformidad_pago")->nullable()->change();
            $table->boolean("documentacion_firmada")->nullable()->change();
            $table->boolean("riesgo_quirurgico")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropForeign(['tipo_historia_clinica_id']);
            $table->dropColumn('tipo_historia_clinica_id');
        });
    }
};

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
            $table->timestamp('fecha_atencion')->nullable()->after('created_at');
            $table->string("nombre_cirugia")->nullable()->after("riesgo_quirurgico");
            $table->string("motivo_atencion")->nullable()->after("nombre_cirugia");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('fecha_atencion');
            $table->dropColumn('nombre_cirugia');
            $table->dropColumn('motivo_atencion');
        }); 
    }
};

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
        Schema::table('tratamientos_mascotas', function (Blueprint $table) {
            $table->integer('cantidad')->nullable()->change();
            $table->integer('observacion')->nullable()->change();
        });

        Schema::table('diagnosticos_mascotas', function (Blueprint $table) {
            $table->integer('observacion')->nullable()->change();
        });

        Schema::table('examenes_auxiliares_mascotas', function (Blueprint $table) {
            $table->integer('observacion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tratamientos_mascotas', function (Blueprint $table) {
            $table->integer('cantidad')->nullable(false)->change();
            $table->integer('observacion')->nullable(false)->change();
        });

        Schema::table('diagnosticos_mascotas', function (Blueprint $table) {
            $table->integer('observacion')->nullable(false)->change();
        });

        Schema::table('examenes_auxiliares_mascotas', function (Blueprint $table) {
            $table->integer('observacion')->nullable(false)->change();
        });
    }
};

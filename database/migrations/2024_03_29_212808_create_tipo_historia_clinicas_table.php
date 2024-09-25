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
        Schema::create('tipos_historias_clinicas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',60);
            $table->timestamps();
        });

        DB::table("tipos_historias_clinicas")->insert([
            [
                "nombre" => "Consulta"
            ],
            [
                "nombre" => "Control"
            ],
            [
                "nombre" => "Cirugia"
            ],
            [
                "nombre" => "Vacuna"
            ],
            [
                "nombre" => "Antiparasitario"
            ],
            [
                "nombre" => "Antipulgas"
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_historias_clinicas');
    }
};

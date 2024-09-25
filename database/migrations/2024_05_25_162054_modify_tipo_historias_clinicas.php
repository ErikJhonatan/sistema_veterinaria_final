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
        DB::statement("SET foreign_key_checks=0");
        DB::table("tipos_historias_clinicas")->truncate();

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
            [
                "nombre" => "Tratamiento"
            ],
        ]);
        DB::statement("SET foreign_key_checks=1");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

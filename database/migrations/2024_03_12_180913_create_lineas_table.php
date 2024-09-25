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
        Schema::create('lineas', function (Blueprint $table) {
            $table->id();
            $table->string('Linea',50);
            $table->timestamps();
        });

        DB::table("lineas")->insert([
            ["Linea" => "Medicina"],
            ["Linea" => "Clinica"],
            ["Linea" => "Peluqueria"],
            ["Linea" => "Farmacia"]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineas');
    }
};

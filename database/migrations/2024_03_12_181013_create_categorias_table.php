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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('IdLinea');
            $table->string('Categoria',50);
            $table->timestamps();

            $table->foreign('idLinea')->references('id')->on('lineas');
        });
        
        DB::table("categorias")->insert([
            ["IdLinea" => 1, "Categoria" => "Pastillas"],
            ["IdLinea" => 2, "Categoria" => "Chequeos"],
            ["IdLinea" => 2, "Categoria" => "Cirugia"],
            ["IdLinea" => 3, "Categoria" => "Baño"],
            ["IdLinea" => 4, "Categoria" => "Vitaminas y Suplementos"]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};

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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idLinea');
            $table->unsignedBigInteger('idCategoria');
            $table->unsignedBigInteger('idSubCategoria')->nullable();
            $table->string('Servicio',60);
            $table->double('CostoServicio');
            $table->double('PrecioServicio');
            $table->boolean('ExoneradoImpuestos');
            $table->timestamps();

            $table->foreign('idLinea')->references('id')->on('lineas');
            $table->foreign('idCategoria')->references('id')->on('categorias');
            $table->foreign('idSubCategoria')->references('id')->on('sub_categorias');

        }); 
        DB::table("servicios")->insert([
            ["idLinea" => 3, "idCategoria" => 4, "idSubCategoria" => NULL, "Servicio" => "Baño perro grande", "CostoServicio" => 100, "PrecioServicio" => 150, "ExoneradoImpuestos" => 0]
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};

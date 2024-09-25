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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProveedor');
            $table->unsignedBigInteger('idUnidadMedida');
            $table->unsignedBigInteger('idPresentacion');
            $table->unsignedBigInteger('idLinea');
            $table->unsignedBigInteger('idCategoria');
            $table->unsignedBigInteger('idSubCategoria')->nullable();
            $table->string('Producto',60);
            $table->string('Marca',40)->nullable();
            $table->string('Contenido',40)->nullable();
            $table->string('CodigoDeBarra',60)->nullable();
            $table->integer('StockMinimo');
            $table->integer('StockMaximo');
            $table->double('PrecioReferencialCompra')->nullable();
            $table->double('PrecioVenta')->nullable();
            $table->boolean('ExoneradoCompra');
            $table->boolean('ExoneradoVenta');
            $table->timestamps();

            $table->foreign('idProveedor')->references('id')->on('proveedores');
            $table->foreign('idUnidadMedida')->references('id')->on('unidades_medidas');
            $table->foreign('idPresentacion')->references('id')->on('presentaciones');
            $table->foreign('idLinea')->references('id')->on('lineas');
            $table->foreign('idCategoria')->references('id')->on('categorias');
            $table->foreign('idSubCategoria')->references('id')->on('sub_categorias');
        });

        DB::table("productos")->insert([
            ["idProveedor" => 1, "idUnidadMedida" => 1, "idPresentacion" => 1, "idLinea" => 1, "idCategoria" => 1, "idSubCategoria" => 1, "Producto" => "MELOSIXAN", "Marca" => "BAYER", "Contenido" => "5", "StockMinimo" => 5, "StockMaximo" => 10, "PrecioReferencialCompra" => 20, "PrecioVenta" => 30, "ExoneradoCompra" => 0, "ExoneradoVenta" => 0],
            ["idProveedor" => 1, "idUnidadMedida" => 2, "idPresentacion" => 2, "idLinea" => 4, "idCategoria" => 5, "idSubCategoria" => null, "Producto" => "Potenza Gel Oral x 120.5 gr", "Marca" => "BIOMONT", "Contenido" => "gel oral", "StockMinimo" => 1, "StockMaximo" => 1000, "PrecioReferencialCompra" => 35.29, "PrecioVenta" => 48, "ExoneradoCompra" => 0, "ExoneradoVenta" => 0]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

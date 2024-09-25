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
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAlmacen');
            $table->unsignedBigInteger('idProducto');
            $table->string('idLote',20);
            $table->string('Lote',20);
            $table->date('FechaVencimineto');
            $table->integer('CantidadEntrada');
            $table->integer('Saldo');

            $table->timestamps();
            

            $table->foreign('idAlmacen')->references('id')->on('almacenes');
            $table->foreign('idProducto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};

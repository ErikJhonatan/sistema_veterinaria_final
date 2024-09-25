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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idAlmacen');
            $table->unsignedBigInteger('idProducto');
            $table->unsignedBigInteger('idTipoOperacion');
            $table->string('Motivo',300);
            $table->integer('Cantidad');
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('users');;
            $table->foreign('idAlmacen')->references('id')->on('almacenes');
            $table->foreign('idTipoOperacion')->references('id')->on('tipos_operaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};

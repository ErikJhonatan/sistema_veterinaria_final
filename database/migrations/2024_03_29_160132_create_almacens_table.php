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
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTipoAlmacen');
            $table->string('Almacen',50);
            $table->string('Estado', 1);
            $table->string('Ventas', 1);
            $table->timestamps();

            $table->foreign('idTipoAlmacen')->references('id')->on('tipos_almacenes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacenes');
    }
};

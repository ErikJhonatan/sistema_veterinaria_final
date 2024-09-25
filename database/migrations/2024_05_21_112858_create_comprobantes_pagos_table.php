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
        Schema::create('comprobantes_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_id')->nullable();
            $table->unsignedBigInteger('medio_pago_id')->nullable();
            $table->unsignedBigInteger('tipo_movimiento_id')->nullable();
            $table->decimal('importe', 10, 2)->nullable();
            $table->text('motivo')->nullable();
            $table->timestamps();

            $table->foreign('comprobante_id')->references('id')->on('comprobantes')->nullOnDelete();
            $table->foreign('medio_pago_id')->references('id')->on('formas_pagos')->nullOnDelete();
            $table->foreign('tipo_movimiento_id')->references('id')->on('tipos_movimientos')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes_pagos');
    }
};

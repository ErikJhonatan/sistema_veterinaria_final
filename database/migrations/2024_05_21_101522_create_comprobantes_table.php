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
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->integer('serie');
            $table->integer('comprobante');
            $table->string('tipo')->default('boleta');
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->decimal('amortizacion', 10, 2)->nullable();
            $table->decimal('dinero_recibido', 10, 2)->nullable();
            $table->decimal('saldo_pendiente', 10, 2)->nullable();
            $table->decimal('vuelto', 10, 2)->nullable();
            $table->boolean('anulado');
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas')->cascadeOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clientes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};

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
        Schema::create('notas_credito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->integer('serie')->nullable();
            $table->integer('comprobante')->nullable();
            $table->string('tipo')->default('nota-de-credito');
            $table->string('motivo')->nullable();
            $table->decimal('importe', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('comprobante_id')->references('id')->on('comprobantes')->cascadeOnDelete();
            $table->foreign('cliente_id')->references('id')->on('clientes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_credito');
    }
};

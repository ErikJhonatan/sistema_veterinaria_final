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
        Schema::create('transaccion_contables', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tipo_transaccion');
            $table->string('metodo_pago');
            $table->string('descripcion');
            $table->foreignId('cuenta_debito_id')->constrained('cuenta_contables');
            $table->foreignId('cuenta_credito_id')->constrained('cuenta_contables');
            $table->decimal('monto', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccion_contables');
    }
};

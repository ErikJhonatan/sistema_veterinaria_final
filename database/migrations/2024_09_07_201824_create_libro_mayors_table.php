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
        Schema::create('libro_mayors', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('debe', 10, 2)->default(0);
            $table->decimal('haber', 10, 2)->default(0);
            $table->decimal('saldo_deudor', 10, 2)->default(0);
            $table->decimal('saldo_acreedor', 10, 2)->default(0);
            $table->foreignId('cuenta_contable_id')->constrained('cuenta_contables');
            $table->foreignId('transaccion_contable_id')->constrained('transaccion_contables')->onDelete('cascade');
            $table->foreignId('libro_diario_id')->constrained('libro_diarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_mayors');
    }
};

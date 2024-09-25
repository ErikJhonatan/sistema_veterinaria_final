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
        Schema::create('libro_diarios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('debe', 10, 2)->default(0);
            $table->decimal('haber', 10, 2)->default(0);
            $table->string('concepto');
            $table->foreignId('cuenta_contable_id')->constrained('cuenta_contables');
            $table->foreignId('transaccion_contable_id')->constrained('transaccion_contables')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_diarios');
    }
};

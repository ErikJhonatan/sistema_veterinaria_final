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
        Schema::create('cuenta_contables', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->boolean('auxiliar')->default(false);
            $table->integer('nivel');
            $table->foreignId('tipo_cuenta_id')->constrained('tipo_cuentas');
            $table->foreignId('cuenta_contable_id')->nullable()->constrained('cuenta_contables');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_contables');
    }
};

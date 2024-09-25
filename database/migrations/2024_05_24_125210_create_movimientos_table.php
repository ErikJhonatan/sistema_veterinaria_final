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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("tipo_movimiento_id");
            $table->foreign("tipo_movimiento_id")->references("id")->on("tipos_movimientos");

            $table->longText("valor_anterior")->nullable();
            $table->longText("valor_nuevo");

            $table->unsignedBigInteger("usuario_id");
            $table->foreign("usuario_id")->references("id")->on("users");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};

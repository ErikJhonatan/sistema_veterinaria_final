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
        Schema::create('equipo_contables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaccion_id')->constrained('transaccion_contables')->onDelete('cascade');
            $table->unsignedBigInteger('transaccion_depreciacion_id');
            $table->foreign('transaccion_depreciacion_id')->references('id')->on('transaccion_contables');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('marca');
            $table->string('modelo');
            $table->string('serie');
            $table->decimal('precio', 10, 2);
            $table->string('metodo_pago');
            $table->string('color');
            $table->string('estado'); // nuevo, usado
            $table->integer('vida_util');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_contables');
    }
};

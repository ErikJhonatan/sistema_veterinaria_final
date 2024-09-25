<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('EstadoEvento',50);
            $table->timestamps();
        });

        DB::table("estados_eventos")->insert([
            ["EstadoEvento" => "Pendiente"],
            ["EstadoEvento" => "En Proceso"],
            ["EstadoEvento" => "Finalizado"],
            ["EstadoEvento" => "Cancelado"]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_eventos');
    }
};

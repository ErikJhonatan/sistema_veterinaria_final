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
        Schema::create('tipos_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('TipoEvento',50);
            $table->timestamps();
        });

        DB::table("tipos_eventos")->insert([
            ["TipoEvento" => "Consulta"],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_eventos');
    }
};

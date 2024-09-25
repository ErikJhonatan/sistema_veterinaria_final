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
        Schema::create('unidades_medidas', function (Blueprint $table) {
            $table->id();
            $table->string('UnidadMedida',50);
            $table->timestamps();
        });

        DB::table("unidades_medidas")->insert([
            ["UnidadMedida" => "ML"],
            ["UnidadMedida" => "GR"]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_medidas');
    }
};

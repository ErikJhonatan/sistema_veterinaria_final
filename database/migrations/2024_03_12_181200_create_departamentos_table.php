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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('Departamento',50);
            $table->timestamps();
        });

        DB::table("departamentos")->insert([
            ["Departamento" => "AMAZONAS"],
            ["Departamento" => "ANCASH"],
            ["Departamento" => "APURÍMAC"],
            ["Departamento" => "AREQUIPA"],
            ["Departamento" => "AYACUCHO"],
            ["Departamento" => "CAJAMARCA"],
            ["Departamento" => "CALLAO"],
            ["Departamento" => "CUSCO"],
            ["Departamento" => "HUANCAVELICA"],
            ["Departamento" => "HUÁNUCO"],
            ["Departamento" => "ICA"],
            ["Departamento" => "JUNÍN"],
            ["Departamento" => "LA LIBERTAD"],
            ["Departamento" => "LAMBAYEQUE"],
            ["Departamento" => "LIMA"],
            ["Departamento" => "LORETO"],
            ["Departamento" => "MADRE DE DIOS"],
            ["Departamento" => "MOQUEGUA"],
            ["Departamento" => "PASCO"],
            ["Departamento" => "PIURA"],
            ["Departamento" => "PUNO"],
            ["Departamento" => "SAN MARTÍN"],
            ["Departamento" => "TACNA"],
            ["Departamento" => "TUMBES"],
            ["Departamento" => "UCAYALI"]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};

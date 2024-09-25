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
        Schema::create('razas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEspecie');
            $table->string('Raza',50);
            $table->timestamps();
            
            $table->foreign('idEspecie')->references('id')->on('especies');
        });

        DB::table("razas")->insert([
            ["idEspecie" => 1, "Raza" => "Pekines"],
            ["idEspecie" => 2, "Raza" => "Criollo"],
            ["idEspecie" => 3, "Raza" => "Loro"]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('razas');
    }
};

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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCliente'); 
            $table->unsignedBigInteger('idEspecie');
            $table->unsignedBigInteger('idRaza');
            $table->unsignedBigInteger('idFrecuencia')->nullable();
            $table->unsignedBigInteger('idDiaPreferido')->nullable();
            $table->string('Mascota',60);
            $table->date('FechaNacimiento');
            $table->string('Microchip',40)->nullable();
            $table->string('Sexo',30)->nullable();
            $table->boolean('Esterilizado')->nullable();
            $table->boolean('Asegurado')->nullable();
            $table->string('Notas',200)->nullable();  
            $table->string('Grooming')->nullable();
            $table->timestamps();

            $table->foreign('idCliente')->references('id')->on('clientes');
            $table->foreign('idEspecie')->references('id')->on('especies');
            $table->foreign('idRaza')->references('id')->on('razas');
            $table->foreign('idFrecuencia')->references('id')->on('frecuencias');
            $table->foreign('idDiaPreferido')->references('id')->on('dias_preferidos');
        });

        
        DB::table("mascotas")->insert([
            [
                "idCliente" => 2, 
                "idEspecie" => 1, 
                "idRaza" => 1, 
                "Mascota" => "Fido", 
                "FechaNacimiento" => "2012-02-22", 
                "Sexo" => "1", 
                "Esterilizado" => true, 
               
            ],
            [
                "idCliente" => 2, 
                "idEspecie" => 2, 
                "idRaza" => 2, 
                "Mascota" => "Cazador", 
                "FechaNacimiento" => "2020-02-10", 
                "Sexo" => "1", 
                "Esterilizado" => true, 

                
            ],
            [
                "idCliente" => 2, 
                "idEspecie" => 3, 
                "idRaza" => 3, 
                "Mascota" => "Flor", 
                "FechaNacimiento" => "2000-02-20", 
                "Sexo" => "2", 
                "Esterilizado" => true, 
                
            ],
            [
                "idCliente" => 1, 
                "idEspecie" => 1, 
                "idRaza" => 1, 
                "Mascota" => "Nena", 
                "FechaNacimiento" => "1999-02-20", 
                "Sexo" => "2", 
                "Esterilizado" => true, 
                
            ],
            [
                "idCliente" => 3, 
                "idEspecie" => 1, 
                "idRaza" => 1, 
                "Mascota" => "Perla", 
                "FechaNacimiento" => "2000-02-02", 
                "Sexo" => "2", 
                "Esterilizado" => false, 
               
            ]
        ]);
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};

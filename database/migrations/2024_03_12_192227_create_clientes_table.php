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
        
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDepartamento');
            $table->unsignedBigInteger('idProvincia');
            $table->unsignedBigInteger('idDistrito');         
            $table->string('Nombre',80);
            $table->string('Apellido',80);
            $table->string('DocumentoIdentidad', 10);
            $table->date('FechaNacimiento');
            $table->string('Email',60)->nullable();
            $table->string('TelefonoFijo',10)->nullable();
            $table->string('TelefonoMovil',10)->nullable();
            $table->string('TelefonoTrabajo',10)->nullable();   
            $table->string('Direccion',200);
            $table->string('ZonaResidencia',1)->nullable();
            $table->boolean('ClienteReferido',60);
            $table->string('Observaciones',200)->nullable();
            $table->string('NombreEmpresa',100)->nullable();  
            $table->string('RegistroTributario', 20)->nullable();
            $table->string('DireccionEmpresa',200)->nullable();
            $table->string('Facebook',100)->nullable();
            $table->string('Instagram',100)->nullable();
            $table->string('ReferenciaDireccion',300)->nullable();
            $table->timestamps();

            $table->foreign('idDepartamento')->references('id')->on('departamentos');
            $table->foreign('idProvincia')->references('id')->on('provincias');
            $table->foreign('idDistrito')->references('id')->on('distritos');
        });

        DB::statement("SET foreign_key_checks=0");
        DB::table("clientes")->insert([
           [
                "idDepartamento" => 15,
                "idProvincia" => 135,
                "idDistrito" => 1402,
                "Nombre" => "dennis",
                "Apellido" => "admin",
                "DocumentoIdentidad" => "20202020",
                "FechaNacimiento" => "2000-10-10",
                "Email" => "dennis@gmail.com",
                "created_at" => now(),
                "updated_at" => now()
           ],
            [
            "idDepartamento" => 15,
            "idProvincia" => 135,
            "idDistrito" => 1406,
            "Nombre" => "pedro",
            "Apellido" => "perez",
            "DocumentoIdentidad" => "20202020",
            "FechaNacimiento" => "2000-10-10",
            "Email" => "pedro@gmail.com",
            "created_at" => now(),
            "updated_at" => now()
            ],
            [
            "idDepartamento" => 7,
            "idProvincia" => 67,
            "idDistrito" => 691,
            "Nombre" => "cristiano",
            "Apellido" => "ronaldo",
            "DocumentoIdentidad" => "10101010",
            "FechaNacimiento" => "1990-02-02",
            "Email" => "cristiano@gmail.com",
            "created_at" => now(),
            "updated_at" => now()
            ],
            [
            "idDepartamento" => 1,
            "idProvincia" => 1,
            "idDistrito" => 251,
            "Nombre" => "alvaro",
            "Apellido" => "petrolino",
            "DocumentoIdentidad" => "30303030",
            "FechaNacimiento" => "1986-11-04",
            "Email" => "petrolino@gmail.com",
            "created_at" => now(),
            "updated_at" => now()
            ]
        ]);
        DB::statement("SET foreign_key_checks=1");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

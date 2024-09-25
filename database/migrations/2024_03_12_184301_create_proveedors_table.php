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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idFormaDePago');
            $table->string('Proveedor',60);
            $table->string('NumeroTributario',20);
            $table->string('TelefonoFijo',40);
            $table->string('TelefonoMovil',40)->nullable();
            $table->string('Email',60)->nullable();
            $table->string('Web',60)->nullable();
            $table->string('Direccion',60)->nullable();
            $table->string('CuentaBancaria',60)->nullable();
            $table->string('Contacto',60)->nullable();
            $table->string('Observacion',60)->nullable();
            $table->timestamps();

            $table->foreign('idFormaDePago')->references('id')->on('formas_pagos');
        });

        DB::table("proveedores")->insert([
            [
                "idFormaDePago" => 1,
                "Proveedor" => "CANSHOP SAC",
                "NumeroTributario" => "1010101010",
                "TelefonoFijo" => "672354",
                "Email" => "admin@admin.com",
                "Direccion" => "av siempre viva 123", 
                "created_at" => "2024-04-20 07:47:02",
                "updated_at" => "2024-04-20 07:47:02"
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};

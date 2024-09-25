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
        Schema::create('formas_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('FormaDePago',50);
            $table->timestamps();
        });

        DB::table("formas_pagos")->insert([
            ["FormaDePago" => "Efectivo"],
            ["FormaDePago" => "Transferencia"],
            ["FormaDePago" => "YAPE"]
        ]);
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formaDePagos');
    }
};

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
        DB::table("tipos_movimientos")->insert([
           [
            "nombre" => "Cliente Eliminacion",
            "slug" => "cliente-eliminacion",
            "created_at" => now(),
            "updated_at" => now()
           ],
            [
            "nombre" => "Servicio Eliminacion",
            "slug" => "servicio-eliminacion",
            "created_at" => now(),
            "updated_at" => now()
            ],
            [
            "nombre" => "Producto Eliminacion",
            "slug" => "producto-eliminacion",
            "created_at" => now(),
            "updated_at" => now()
            ],
            [
            "nombre" => "Mascota Eliminacion",
            "slug" => "mascota-eliminacion",
            "created_at" => now(),
            "updated_at" => now()
            ],
      
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

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
                "nombre" => "Cliente Edicion",
                "slug" => "cliente-edicion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Cliente Creacion",
                "slug" => "cliente-creacion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Servicio Creacion",
                "slug" => "servicio-creacion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Servicio Edicion",
                "slug" => "servicio-edicion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Producto Edicion",
                "slug" => "producto-edicion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Producto Creacion",
                "slug" => "producto-creacion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Mascota Creacion",
                "slug" => "mascota-creacion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Mascota Edicion",
                "slug" => "mascota-edicion",
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

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
        // Schema::table('tipos_movimientos', function (Blueprint $table) {
        //     $table->id();
        //     $table->text('nombre');
        //     $table->text('slug');
        //     $table->timestamps();
        // });

        DB::table("tipos_movimientos")->insert([
            [
                "nombre" => "Venta",
                "slug" => "venta",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Compra",
                "slug" => "compra",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Anulación",
                "slug" => "anulacion",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "nombre" => "Directo",
                "slug" => "directo",
                "created_at" => now(),
                "updated_at" => now()
            ]
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

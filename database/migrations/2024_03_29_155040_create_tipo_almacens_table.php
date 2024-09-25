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
        Schema::create('tipos_almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('TipoAlmacen',50);
            $table->timestamps();
        });

        DB::table("tipos_almacenes")->insert([
            ["TipoAlmacen" => "Sede Chorrillos"],
            ["TipoAlmacen" => "Sede Lurirn"]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_almacenes');
    }
};

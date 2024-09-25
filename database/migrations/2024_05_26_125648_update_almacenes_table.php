<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('almacenes', function (Blueprint $table) {
            $table->dropForeign(['idTipoAlmacen']);

            $table->renameColumn('idTipoAlmacen', 'almacen_tipo_id');
            $table->renameColumn('Almacen', 'nombre');
            $table->renameColumn('Estado', 'estado');
            $table->renameColumn('Ventas', 'ventas');

            $table->foreign('almacen_tipo_id')->references('id')->on('tipos_almacenes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

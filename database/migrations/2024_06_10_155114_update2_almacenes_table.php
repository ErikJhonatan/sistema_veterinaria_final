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
            $table->dropForeign(['almacen_tipo_id']);
            $table->renameColumn('almacen_tipo_id', 'sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes')->onDelete('cascade');
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

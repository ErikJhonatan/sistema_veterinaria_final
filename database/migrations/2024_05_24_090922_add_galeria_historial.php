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
        Schema::table('historia_clinica_adjuntos', function (Blueprint $table) {
            $table->id();
        });
        

        Schema::create("mascota_galeria", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("mascota_id");
            $table->foreign("mascota_id")->references("id")->on("mascotas");
            $table->string("path");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("mascota_galeria");
        Schema::table('historia_clinica_adjuntos', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
};

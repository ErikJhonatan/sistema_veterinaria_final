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
        Schema::create('sub_categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCategoria');
            $table->string('SubCategoria',50);
            $table->timestamps();

            $table->foreign('idCategoria')->references('id')->on('categorias');
        });

        DB::table("sub_categorias")->insert([
            ["idCategoria" => 1, "SubCategoria" => "Pastilla"],
            ["idCategoria" => 3, "SubCategoria" => "Neurologica"]
        ]);
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subCategorias');
    }
};

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
        Schema::create("additional_information", function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->bigInteger('id_usuario')->unsiged();
            $table->timestamps(); 
        }); //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

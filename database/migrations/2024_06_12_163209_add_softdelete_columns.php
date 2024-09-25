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
        Schema::table('eventos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('servicios', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('mascotas', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('servicios', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('mascotas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('productos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

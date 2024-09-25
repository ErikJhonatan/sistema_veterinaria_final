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

        Schema::table('comprobantes', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_id')->nullable()->change();

            DB::table('comprobantes')->whereNotIn('tipo_id', function ($query) {
                $query->select('id')->from('tipos_comprobantes');
            })->update(['tipo_id' => null]);

            Schema::table('comprobantes', function (Blueprint $table) {
                $table->foreign('tipo_id')->references('id')->on('tipos_comprobantes')->onDelete('set null');
            });
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

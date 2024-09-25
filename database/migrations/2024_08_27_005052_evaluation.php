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
        Schema::create("evalution_employes", function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employe_id')->unsigned();
            $table->bigInteger('evaluator')->unsigned();
            $table->integer('quality_work');
            $table->integer('quantity_work');
            $table->integer('CDP');
            $table->integer('LDM');
            $table->string('COMDL');
            $table->integer('CT');
            $table->integer('CDA');
            $table->string('COMHT');
            $table->integer('TEE');
            $table->integer('Comu');
            $table->integer('LiD');
            $table->string('COMHI');
            $table->integer('INI');
            $table->integer('ACT');
            $table->integer('FIAB');
            $table->string('COMCYA');
            $table->integer('PC');
            $table->integer('DH');
            $table->integer('FR');
            $table->string('COMDES');
            $table->integer('OE');
            $table->integer('IEN');
            $table->integer('COMOR');
            $table->integer('AUTO');
            $table->integer('EPP');
            $table->integer('EDSUP');
            $table->integer('EDSUB');
            $table->integer('COME360');
            $table->integer('PF');
            $table->integer('ADM');
            $table->integer('OPEPP');
            $table->integer('PDD');
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

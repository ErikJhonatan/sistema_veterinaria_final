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
        Schema::create("Attendance", function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employe')->unsigned();
            $table->string('start_work');
            $table->string('delay_start');
            $table->string('start_wrok_registre');
            $table->string('end_work');
            $table->string('delay_end');
            $table->string('end_work_registre');
            $table->string('lack');
            $table->string('snack_start');
            $table->string('snack_end');
            $table->string('delay_snack');
            $table->timestamps();
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

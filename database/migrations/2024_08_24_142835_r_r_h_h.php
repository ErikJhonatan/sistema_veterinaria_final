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
        Schema::create("employes", function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->date('birthdate');
            $table->bigInteger('genere')->unsigned();
            $table->string('address');
            $table->string('phone_emergency');
            $table->bigInteger('employee_title')->unsigned();
            $table->bigInteger('work_area')->unsigned();
            $table->bigInteger('supervisor')->unsigned();
            $table->date('start_work');
            $table->bigInteger('employment_status')->unsigned();
            $table->time('start_working_hours');
            $table->time('end_working_hours');
            $table->bigInteger('degree_education');
            $table->bigInteger('path_certification')->unsigned();
            $table->boolean('animal_handling_experience');
            $table->string('path_health_safety_information');
            $table->string('path_medical_conditions');
            $table->string('path_immunization_records');
            $table->bigInteger('path_job_references');
            $table->bigInteger('additional_information');
            $table->string('notes');
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

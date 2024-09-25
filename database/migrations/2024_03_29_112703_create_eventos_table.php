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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCliente'); 
            $table->unsignedBigInteger('idMascota');
            $table->unsignedBigInteger('idTipoEvento');
            $table->unsignedBigInteger('idEstadoEvento');
            $table->unsignedBigInteger('idUsuario'); 
            $table->unsignedBigInteger('idNotificacion'); 
            $table->string('Evento',60);
            $table->dateTime('FechaInicio');
            $table->dateTime('FechaFin');
            $table->string('Observacion',200);
            $table->string('Color',20);
            $table->boolean('Notificacion');
            $table->timestamps();

            $table->foreign('idCliente')->references('id')->on('clientes');
            $table->foreign('idMascota')->references('id')->on('mascotas');
            $table->foreign('idTipoEvento')->references('id')->on('tipos_eventos');
            $table->foreign('idEstadoEvento')->references('id')->on('estados_eventos');
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idNotificacion')->references('id')->on('notificaciones');
        });

        DB::table("eventos")->insert([
            [
                "idCliente" => 1,
                "idMascota" => 4,
                "idTipoEvento" => 1,
                "idEstadoEvento" => 1,
                "idUsuario" => 1,
                "idNotificacion" => 1,
                "Evento" => "corte de pelo",
                "FechaInicio" => "2024-04-28",
                "FechaFin" => "2024-04-28",
                "Observacion" => "nada",
                "Color" => "",
                "Notificacion" => 0
            ],
            [
                "idCliente" => 3,
                "idMascota" => 5,
                "idTipoEvento" => 1,
                "idEstadoEvento" => 1,
                "idUsuario" => 1,
                "idNotificacion" => 1,
                "Evento" => "baño de mascota",
                "FechaInicio" => "2024-04-28",
                "FechaFin" => "2024-04-28",
                "Observacion" => "nada",
                "Color" => "",
                "Notificacion" => 0
            ],
            [
                "idCliente" => 2,
                "idMascota" => 1,
                "idTipoEvento" => 1,
                "idEstadoEvento" => 1,
                "idUsuario" => 1,
                "idNotificacion" => 1,
                "Evento" => "Control",
                "FechaInicio" => "2024-04-28",
                "FechaFin" => "2024-04-28",
                "Observacion" => "ninguna",
                "Color" => "",
                "Notificacion" => 0
            ],
            [
                "idCliente" => 1,
                "idMascota" => 4,
                "idTipoEvento" => 1,
                "idEstadoEvento" => 1,
                "idUsuario" => 1,
                "idNotificacion" => 1,
                "Evento" => "baño de mascota",
                "FechaInicio" => "2024-04-29",
                "FechaFin" => "2024-04-29",
                "Observacion" => "ninguna",
                "Color" => "",
                "Notificacion"
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

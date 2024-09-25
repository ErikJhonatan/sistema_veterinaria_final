<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $EstadoEvento =['Pendiente','Confirmado','Realizado','Notificado','Cancelado'];

        foreach( $EstadoEvento as $estEve){
            DB::table('estadoEventos')->insert(['EstadoEvento'=>$estEve]);

        }
    }
}

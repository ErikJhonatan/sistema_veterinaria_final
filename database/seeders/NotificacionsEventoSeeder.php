<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificacionsEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $NotificacionEvento =['Pendiente','Confirmado','Realizado','Notificado','Cancelado'];

        foreach( $NotificacionEvento as $notEve){
            DB::table('notificaciones')->insert(['notificacion'=>$notEve]);

        }
    }
}

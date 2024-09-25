<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TipoEvento =['Alimento',
        'Antiparasitario',
        'Antipulgas',
        'Baño',
        'Baño (traslado)',
        'Baño y corte',
        'Baño y corte (traslado)',
        'Cirugía',
        'Cita',
        'Consulta',
        'Control',
        'Destartarización',
        'Ecografía',
        'Entrega de resultados',
        'Escáner',
        'Exámenes de Laboratorio',
        'Hospedaje',
        'Llamada Telefónica',
        'No disponible',
        'Plan de salud',
        'Post Venta Peluquería',
        'Profilaxis',
        'Prueba de laboratorio',
        'Radiografía',
        'Recordatorio de baño',
        'Teleconsulta',
        'Toma de muestras',
        'Transporte',
        'Tratamiento',
        'Vacuna'];

        foreach( $TipoEvento as $tipEve){
            DB::table('tipo_eventos')->insert(['TipoEvento'=>$tipEve]);

        }
    }
}

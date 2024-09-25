<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoHistoriaClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoHistoriaClinicas =['Consulta',
        'Control',
        'Cirugía',
        'Vacuna',
        'Antiparasitario',
        'Antipulgas',
        'Internamiento',
        'Triaje',
        'Profilaxis',
        'Defunción'];

        foreach( $tipoHistoriaClinicas as $tipHisCli){
            DB::table('tipos_historias_clinicas')->insert(['nombre'=>$tipHisCli]);

        }
    }
}

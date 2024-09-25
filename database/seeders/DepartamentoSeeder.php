<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = ['AMAZONAS',
        'ANCASH',
        'APURÍMAC',
        'AREQUIPA',
        'AYACUCHO',
        'CAJAMARCA',
        'CALLAO',
        'CUSCO',
        'HUANCAVELICA',
        'HUÁNUCO',
        'ICA',
        'JUNÍN',
        'LA LIBERTAD',
        'LAMBAYEQUE',
        'LIMA',
        'LORETO',
        'MADRE DE DIOS',
        'MOQUEGUA',
        'PASCO',
        'PIURA',
        'PUNO',
        'SAN MARTÍN',
        'TACNA',
        'TUMBES',
        'UCAYALI'];

        foreach( $departamentos as $depto){
            DB::table('departamentos')->insert(['Departamento'=>$depto]);
        }
    }
}

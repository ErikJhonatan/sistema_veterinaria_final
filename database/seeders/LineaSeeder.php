<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LineaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $linea = ['ARENA PARA GATO',
        'CLINICA',
        'CREMACIÓN',
        'FARMACIA',
        'HOSPEDAJE',
        'PELUQUERÍA',
        'PET SHOP',
        'SERVICIO',
        'TRANSPORTE'];

        foreach( $linea as $lin){
            DB::table('lineas')->insert(['Linea'=>$lin]); 
        }
    }
}

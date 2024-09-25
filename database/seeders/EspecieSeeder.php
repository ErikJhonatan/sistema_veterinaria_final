<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especies = [
            'AVE',
            'BOVINO',
            'CAMÉLIDO',
            'CANINO',
            'CAPRINO',
            'CONEJO',
            'CUY (COBAYO)',
            'EQUINO',
            'EXÓTICO',
            'FAUNA SILVESTRE',
            'FELINO',
            'HAMSTER',
            'MUSTELIDO',
            'OTROS',
            'OVINO',
            'PORCINO',
            'PRIMATE',
            'REPTIL',
            'ROEDOR'
        ];

        foreach( $especies as $especie){
            DB::table('especies')->insert(['Especie'=>$especie]);
        }
    }
}

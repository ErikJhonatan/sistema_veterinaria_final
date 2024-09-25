<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presentacion = ['Ampolla','Blister','Bolsa','Botella','Caja','Capsula','Cojin','Frasco','Galon','Gotero','Jeringa','Lata','Paquete','Pipeta','Pote','Rollo','Sobre','Tableta','Tubo','Unidad','Vial'];

        foreach( $presentacion as $prese){
            DB::table('presentaciones')->insert(['Presentacion'=>$prese]);
        }
    }
}

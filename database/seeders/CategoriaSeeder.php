<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Categoria = [
            ['4','ANALGESICOS Y ANTIPIRETICOS'],
            ['4','ANESTÉSICOS Y TRANQUILIZANTES'],
            ['2','ALIMENTOS DE PRESCRIPCIÓN']
        ];

        foreach( $Categoria as $cat){
            DB::table('categorias')->insert(['idLinea'=>$cat[0],'Categoria'=>$cat[1]]);
        }
    }
}

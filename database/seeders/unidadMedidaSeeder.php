<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class unidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidadMedida = ['ML','LT','GR','MG','KG','UL','PLG','CM','YD','MT','N.A.','CL','CPMD','UND','OZ','LB'];

        foreach( $unidadMedida  as $unidad){
            DB::table('unidades_medidas')->insert(['nombre'=>$unidad]);
        }
    }
}

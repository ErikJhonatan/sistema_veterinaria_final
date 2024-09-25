<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposComprobantes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos =[
            ['id' => 1, 'nombre' => 'BOLETA'],
            ['id' => 2, 'nombre' =>  'FACTURA'],
            ['id' => 3, 'nombre' =>  'NOTA_VENTA']
        ];

        foreach( $tipos as $tipo) {
            DB::table('tipos_comprobantes')->insert($tipo);
        }
    }
}

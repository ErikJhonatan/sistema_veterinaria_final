<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoOperacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TipoOperaciones =[
            ['1','Compra'],
            ['1','saldo Inicial'],
            ['1','Entrada por devolución del cliente'],
            ['1','Ajuste por diferencia de inventario'],
            ['1','Muestras médicas'],
            ['1','Otros'],
            ['2','leccione'],
            ['2','Ajuste por diferencia de inventario'],
            ['2','Devolución entregada'],
            ['2','Premio'],
            ['2','Donación'],
            ['2','Salida a producción'],
            ['2','Retiro'],
            ['2','Mermas'],
            ['2','Salida por devolución al proveedor'],
            ['2','Publicidad'],
            ['2','Salida por identificación errónea'],
            ['2','Otros'],
            ['3','Transferencia']
        ];
    
        foreach( $TipoOperaciones as $TipOPe){
            DB::table('tipoOperaciones')->insert(['TipoMovimiento'=>$TipOPe[0],'TipoOperacion'=>$TipOPe[1]]);
        }
    }
}

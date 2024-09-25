<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoAlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $TipoAlmacen =['Primario','Secundario'];

        foreach( $TipoAlmacen as $tipAlma){
            DB::table('tipoAlmacenes')->insert(['TipoAlmacen'=>$tipAlma]);

        }
    }
}

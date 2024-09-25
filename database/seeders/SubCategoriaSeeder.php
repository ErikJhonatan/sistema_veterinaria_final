<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategoria = [
            ['3','BOLSA DE 2.1 KG HASTA 8 KG']
        ];

        foreach( $subCategoria as $SubCat){
            DB::table('subcategorias')->insert(['idCategoria'=>$SubCat[0],'SubCategoria'=>$SubCat[1]]);
        }
    }
}

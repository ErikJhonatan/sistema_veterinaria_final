<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RazaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $razas =[
            ['1','AVE'],
            ['1','CACATUA']
        ];

        foreach( $razas as $raza){
            DB::table('razas')->insert(['idEspecie'=>$raza[0],'Raza'=>$raza[1]]);
        }
    }
}

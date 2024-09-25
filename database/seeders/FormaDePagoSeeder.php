<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaDePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formaDePago = ['CONTADO','CREDITO','CHEQUE','LETRA DE CAMBIO'];

        foreach( $formaDePago as $forma){
            DB::table('formas_pagos')->insert(['nombre'=>$forma]);
        }
    }
}

<?php

namespace Database\Seeders;

use Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TipoMovimiento;

class TiposMovimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_movimientos = [
            'VENTA',
            'COMPRA',
            'ANULACIÓN',
            'DIRECTO',
        ];

        foreach ($tipos_movimientos as $tipo_movimiento) {
            TipoMovimiento::insert([
                'nombre' => $tipo_movimiento,
                'slug' => Str::slug($tipo_movimiento),
            ]);
        }
    }
}

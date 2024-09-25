<?php

namespace Database\Seeders;

use Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\EstadoVenta;

class EstadosVentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados_venta = [
            'Pagada',
            'Pendiente',
            'Anulada',
        ];

        foreach ($estados_venta as $estado) {
            EstadoVenta::insert([
                'nombre' => $estado,
                'slug' => Str::slug($estado),
            ]);
        }
    }
}

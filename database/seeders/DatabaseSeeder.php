<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contabilidad\TipoCuenta;
use App\Models\Contabilidad\CuentaContable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);

        $tiposCuentas = [
            'Activo disponible y exigible',
            'Activo realizable',
            'Activo inmovilizado',
            'Pasivo',
            'Patrimonio neto',
            'Gastos por naturaleza',
            'Ingresos',
            'Saldos intermediarios de gestión y determinación del resultado del ejercicio',
            'Costos de producción y gastos por función',
            'Cuentas de orden',
        ];
        foreach ($tiposCuentas as $nombre) {
            TipoCuenta::factory()->create(['nombre' => $nombre]);
        }

        $cuentasContables = [
            ['codigo' => '10', 'nombre' => 'EFECTIVO Y EQUIVALENTES DE EFECTIVO', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '101', 'nombre' => 'CAJA', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 1],
            ['codigo' => '106', 'nombre' => 'DEPÓSITOS EN INSTITUCIONES FINANCIERAS', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 1],
            ['codigo' => '1061', 'nombre' => 'DEPOSITOS DE AHORRO', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 3],
            ['codigo' => '20', 'nombre' => 'MERCADERÍAS', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '201', 'nombre' => 'MERCADERÍAS MANUFACTURADAS', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 5],
            ['codigo' => '2011', 'nombre' => 'MERCADERÍAS MANUFACTURADAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 6],
            ['codigo' => '20111', 'nombre' => 'COSTO', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 7],
            ['codigo' => '20112', 'nombre' => 'VALOR RAZONABLE', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 7],
            ['codigo' => '33', 'nombre' => 'INMUEBLES, MAQUINARIA Y EQUIPO', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '333', 'nombre' => 'MAQUINARIAS Y EQUIPOS DE EXPLOTACIÓN', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 9],
            ['codigo' => '3331', 'nombre' => 'MAQUINARIAS Y EQUIPOS DE EXPLOTACIÓN', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 10],
            ['codigo' => '33311', 'nombre' => 'COSTO DE ADQUISICIÓN O CONSTRUCCIÓN', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 11],
            ['codigo' => '33312', 'nombre' => 'REVALUACIÓN', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 11],
            ['codigo' => '33313', 'nombre' => 'COSTO DE FINANCIACIÓN – MAQUINARIAS Y EQUIPOS DE EXPLOTACIÓN', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 11],
            ['codigo' => '42', 'nombre' => 'CUENTAS POR PAGAR COMERCIALES – TERCEROS', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '421', 'nombre' => 'FACTURAS, BOLETAS Y OTROS COMPROBANTES POR PAGAR', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 13],
            ['codigo' => '4211', 'nombre' => 'NO EMITIDAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 14],
            ['codigo' => '4212', 'nombre' => 'EMITIDAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 14],
            ['codigo' => '40', 'nombre' => 'TRIBUTOS, CONTRAPRESTACIONES Y APORTES AL SISTEMA DE PENSIONES Y DE SALUD POR PAGAR', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '401', 'nombre' => 'GOBIERNO CENTRAL', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 17],
            ['codigo' => '4011', 'nombre' => 'IMPUESTO GENERAL A LAS VENTAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 18],
            ['codigo' => '40111', 'nombre' => 'IGV – CUENTA PROPIA', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 19],
            ['codigo' => '40112', 'nombre' => 'IGV – SERVICIOS PRESTADOS POR NO DOMICILIADOS', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 19],
            ['codigo' => '40113', 'nombre' => 'IGV – RÉGIMEN DE PERCEPCIONES', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 19],
            ['codigo' => '40114', 'nombre' => 'IGV – RÉGIMEN DE RETENCIONES', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 19],
            ['codigo' => '50', 'nombre' => 'CAPITAL', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '501', 'nombre' => 'CAPITAL SOCIAL', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 21],
            ['codigo' => '59', 'nombre' => 'RESULTADOS ACUMULADOS', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '591', 'nombre' => 'UTILIDADES NO DISTRIBUIDAS', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 23],
            ['codigo' => '592', 'nombre' => 'PÉRDIDAS ACUMULADAS', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 23],
            ['codigo' => '70', 'nombre' => 'VENTAS', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '701', 'nombre' => 'MERCADERÍAS', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 25],
            ['codigo' => '7011', 'nombre' => 'MERCADERÍAS MANUFACTURADAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 26],
            ['codigo' => '704', 'nombre' => 'PRESTACIÓN DE SERVICIOS', 'auxiliar' => false, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 25],
            ['codigo' => '7041', 'nombre' => 'TERCEROS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 28],
            ['codigo' => '601', 'nombre' => 'MERCADERÍAS', 'auxiliar' => false, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 25],
            ['codigo' => '6011', 'nombre' => 'MERCADERÍAS MANUFACTURADAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 26],
            ['codigo' => '62', 'nombre' => 'GASTOS DE PERSONAL, DIRECTORES Y GERENTES', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '621', 'nombre' => 'REMUNERACIONES', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 31],
            ['codigo' => '626', 'nombre' => 'GERENTES', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 31],
            ['codigo' => '63', 'nombre' => 'GASTOS DE SERVICIOS PRESTADOS POR TERCEROS', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '635', 'nombre' => 'ALQUILERES', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 33],
            ['codigo' => '6351', 'nombre' => 'TERRENOS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 34],
            ['codigo' => '6352', 'nombre' => 'EDIFICACIONES', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 34],
            ['codigo' => '6353', 'nombre' => 'MAQUINARIAS Y EQUIPOS DE EXPLOTACIÓN', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 34],
            ['codigo' => '6354', 'nombre' => 'EQUIPO DE TRANSPORTE', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 34],
            ['codigo' => '6356', 'nombre' => 'EQUIPOS DIVERSOS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 34],
            ['codigo' => '636', 'nombre' => 'SERVICIOS BÁSICOS', 'auxiliar' => false, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 33],
            ['codigo' => '6361', 'nombre' => 'ENERGÍA ELÉCTRICA', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '6362', 'nombre' => 'GAS', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '6363', 'nombre' => 'AGUA', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '6364', 'nombre' => 'TELÉFONO', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '6365', 'nombre' => 'INTERNET', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '6366', 'nombre' => 'RADIO', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '6367', 'nombre' => 'CABLE', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 36],
            ['codigo' => '68', 'nombre' => 'VALUACIÓN Y DETERIORO DE ACTIVOS Y PROVISIONES', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '681', 'nombre' => 'DEPRECIACIÓN', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 38],
            ['codigo' => '6814', 'nombre' => 'DEPRECIACIÓN DE INMUEBLES, MAQUINARIA Y EQUIPO - COSTO', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 39],
            ['codigo' => '68141', 'nombre' => 'EDIFICACIONES', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 40],
            ['codigo' => '68142', 'nombre' => 'MAQUINARIAS Y EQUIPOS DE EXPLOTACIÓN', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 40],
            ['codigo' => '68143', 'nombre' => 'EQUIPO DE TRANSPORTE', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 40],
            ['codigo' => '68144', 'nombre' => 'MUEBLES Y ENSERES', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 40],
            ['codigo' => '68145', 'nombre' => 'EQUIPOS DIVERSOS', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 40],
            ['codigo' => '68146', 'nombre' => 'HERRAMIENTAS Y UNIDADES DE REEMPLAZO', 'auxiliar' => true, 'nivel' => 4, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 40],
            ['codigo' => '64', 'nombre' => 'GASTOS POR TRIBUTOS', 'auxiliar' => false, 'nivel' => 1, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => null],
            ['codigo' => '641', 'nombre' => 'GOBIERNO CENTRAL', 'auxiliar' => true, 'nivel' => 2, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 42],
            ['codigo' => '6411', 'nombre' => 'IMPUESTO GENERAL A LAS VENTAS Y SELECTIVO AL CONSUMO', 'auxiliar' => true, 'nivel' => 3, 'tipo_cuenta_id' => 1, 'cuenta_contable_id' => 43],
        ];

        foreach ($cuentasContables as $cuentaContable) {
            CuentaContable::factory()->create($cuentaContable);
        }

    }
}

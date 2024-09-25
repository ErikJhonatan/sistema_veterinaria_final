<?php

namespace App\Http\Controllers\TransaccionContable;

use Illuminate\Http\Request;
use App\Models\Contabilidad\LibroMayor;
use App\Models\Contabilidad\CuentaContable;
use Dompdf\Dompdf;
use App\Http\Controllers\Controller;


class ReporteContabilidadController extends Controller
{
    public function index() {
        return view('contabilidad.reportes');
    }

    public function estadoResultados(Request $request){
        $anio = $request->validate([
            'anio' => 'required|integer|min:2024'
        ])['anio'];
        // Definir fechas de inicio y fin del ejercicio
        $fecha_inicio = $anio.'-01-01';
        $fecha_fin = $anio.'-12-31';

        // Calcular sumas
        $cuentas_ingreso_venta = [$this->getIdCuenta(7011)];
        $suma_ingresos_venta = LibroMayor::whereIn('cuenta_contable_id', $cuentas_ingreso_venta)
                                         ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                         ->sum('haber');

        $cuentas_ingreso_servicio = [$this->getIdCuenta(7041)];
        $suma_ingresos_servicio = LibroMayor::whereIn('cuenta_contable_id', $cuentas_ingreso_servicio)
                                           ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                           ->sum('haber');

        $cuentas_gasto_servicio = [
            $this->getIdCuenta(6411),
            $this->getIdCuenta(6361),
            $this->getIdCuenta(6363),
            $this->getIdCuenta(6365),
            $this->getIdCuenta(6364),
            $this->getIdCuenta(6351),
            $this->getIdCuenta(6356)
        ];

        $cuentas_gasto_personal = [
            $this->getIdCuenta(621)
        ];

        $cuentas_gasto_impuesto = [
            $this->getIdCuenta(6411)
        ];

        $suma_gastos_servicio = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_servicio)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');

        $suma_gastos_personal = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_personal)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');
        $suma_gastos_impuesto = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_impuesto)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');

        // Calcular utilidad bruta y neta
        $utilidad_bruta = $suma_ingresos_venta + $suma_ingresos_servicio;

        $utilidad_neta = $utilidad_bruta - ($suma_gastos_servicio + $suma_gastos_personal + $suma_gastos_impuesto);

        // Crear PDF
        $pdf = new Dompdf();
        $pdf->loadHtml('
            <h1>Estado de Resultados</h1>
            <p><strong>Periodo:</strong> '.$fecha_inicio.' - '.$fecha_fin.'</p>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 8px; text-align: left;">Descripción</th>
                        <th style="padding: 8px; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px;">Ingresos por venta</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_ingresos_venta, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Ingresos por servicio</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_ingresos_servicio, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Ingresos</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($suma_ingresos_venta + $suma_ingresos_servicio, 2).'</td>
                    <tr>
                        <td style="padding: 8px;">Gastos por servicios</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_servicio, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Gastos por personal</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_personal, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Gastos por impuestos</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_impuesto, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Gastos</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($suma_gastos_servicio + $suma_gastos_personal, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Utilidad Bruta</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($utilidad_bruta, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Utilidad Neta</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($utilidad_neta, 2).'</td>
                    </tr>
                </tbody>
            </table>
        ');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('estado_resultados.pdf');
    }

    public function balanceGeneral(Request $request)
    {
        $anio = $request->validate([
            'anio' => 'required|integer|min:2024'
        ])['anio'];
        // Definir fechas de inicio y fin del ejercicio
        $fecha_inicio = $anio.'-01-01';
        $fecha_fin = $anio.'-12-31';

        $caja = $this->getIdCuenta(101);
        $banco = $this->getIdCuenta(1061);

        $suma_caja = LibroMayor::where('cuenta_contable_id', $caja)
                               ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                               ->sum('debe');
        $suma_banco = LibroMayor::where('cuenta_contable_id', $banco)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                ->sum('debe');

        $inventario = $this->getIdCuenta(20111);
        $suma_inventario = LibroMayor::where('cuenta_contable_id', $inventario)
                                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                    ->sum('debe');

        $capital = $this->getIdCuenta(501);
        $suma_capital = LibroMayor::where('cuenta_contable_id', $capital)
                                  ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                  ->sum('haber');
                                   // Calcular sumas
        $cuentas_ingreso_venta = [$this->getIdCuenta(7011)];
        $suma_ingresos_venta = LibroMayor::whereIn('cuenta_contable_id', $cuentas_ingreso_venta)
                                         ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                         ->sum('haber');

        $cuentas_ingreso_servicio = [$this->getIdCuenta(7041)];
        $suma_ingresos_servicio = LibroMayor::whereIn('cuenta_contable_id', $cuentas_ingreso_servicio)
                                           ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                           ->sum('haber');

        $cuentas_gasto_servicio = [
            $this->getIdCuenta(6411),
            $this->getIdCuenta(6361),
            $this->getIdCuenta(6363),
            $this->getIdCuenta(6365),
            $this->getIdCuenta(6364),
            $this->getIdCuenta(6351),
            $this->getIdCuenta(6356)
        ];

        $cuentas_gasto_personal = [
            $this->getIdCuenta(621)
        ];

        $cuentas_gasto_impuesto = [
            $this->getIdCuenta(6411)
        ];

        $cuenta_gasto_inventario = $this->getIdCuenta(20111);

        $suma_gastos_servicio = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_servicio)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');

        $suma_gastos_personal = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_personal)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');
        $suma_gastos_impuesto = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_impuesto)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');
        // si el libro mayor, en la transaccion contable tiene a banco o caja se debe descontar de suma_caja o suma_banco
        $gastos_inventario = LibroMayor::where('cuenta_contable_id', $cuenta_gasto_inventario)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])->get();
        $suma_gastos_inventario = 0;
        foreach($gastos_inventario as $gasto){
            $transaccion = $gasto->transaccion_contable;
            $cuentaCredito = $transaccion->cuenta_credito;
            if($cuentaCredito->id == $caja){
                $suma_caja -= $transaccion->monto;
                $suma_gastos_inventario += $transaccion->monto;
            }
            else if($cuentaCredito->id == $banco){
                $suma_banco -= $transaccion->monto;
                $suma_gastos_inventario += $transaccion->monto;
            }
        }


        // Calcular utilidad bruta y neta
        $utilidad_bruta = $suma_ingresos_venta + $suma_ingresos_servicio;
        $pasivo_corriente = $suma_gastos_servicio + $suma_gastos_personal + $suma_gastos_impuesto + $suma_gastos_inventario;
        $utilidad_no_distribuida = $utilidad_bruta - $pasivo_corriente;

        $pdf = new Dompdf();

        // pdf con dos columnas ACTIVO y PASIVO | PATRIMONIO NETO
        // Al final de cada columna se muestra el total del activo y del pasivo + patrimonio neto
        $pdf->loadHtml('
            <h1>Balance General</h1>
            <p><strong>Periodo:</strong> '.$fecha_inicio.' - '.$fecha_fin.'</p>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 8px; text-align: left;">ACTIVO</th>
                        <th style="padding: 8px; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px;">Caja</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_caja, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Banco</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_banco, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Inventario</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_inventario, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Activo</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($suma_caja + $suma_banco + $suma_inventario, 2).'</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 8px; text-align: left;">PASIVO | PATRIMONIO NETO</th>
                        <th style="padding: 8px; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px; font-weight: bold">Pasivo</td>
                        <td style=""></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Pasivo Corriente</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Proveedores</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_servicio + $suma_gastos_inventario, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Gasto por Personal</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_personal, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Obligaciones Tributarias</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_impuesto, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Pasivo</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($pasivo_corriente, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Patrimonio Neto</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Capital Social (Aporte)</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_capital, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Utilidad no distribuida</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($utilidad_no_distribuida, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Patrimonio Neto</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($suma_capital + $utilidad_no_distribuida, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Pasivo | Patrimonio Neto</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($pasivo_corriente + $suma_capital + $utilidad_no_distribuida, 2).'</td>
                    </tr>
                </tbody>
            </table>
            <div>
                <div>
                    <p style="text-align: center; font-weight: bold;">Total Activo: '.number_format($suma_caja + $suma_banco + $suma_inventario, 2).'</p>
                    <p style="text-align: center; font-weight: bold;">Total Pasivo | Patrimonio Neto: '.number_format($pasivo_corriente + $suma_capital + $utilidad_no_distribuida, 2).'</p>
                </div>
                <p style="text-align: center; font-weight: bold;">Balance General al '.$fecha_fin.'</p>
            </div>

        ');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('balance_general.pdf');

    }

    public function flujoEfectivo(Request $request)
    {
        $anio = $request->validate([
            'anio' => 'required|integer|min:2024'
        ])['anio'];
        // Definir fechas de inicio y fin del ejercicio
        $fecha_inicio = $anio.'-01-01';
        $fecha_fin = $anio.'-12-31';
        // items a considerar
        // flujo efectivo de operaciones
        // Datos:
        // - Cobros de clientes
        $cuentas_ingreso_venta = [$this->getIdCuenta(7011)];
        $suma_ingresos_venta = LibroMayor::whereIn('cuenta_contable_id', $cuentas_ingreso_venta)
                                         ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                         ->sum('haber');

        $cuentas_ingreso_servicio = [$this->getIdCuenta(7041)];
        $suma_ingresos_servicio = LibroMayor::whereIn('cuenta_contable_id', $cuentas_ingreso_servicio)
                                           ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                           ->sum('haber');
        $cobros_clientes = $suma_ingresos_venta + $suma_ingresos_servicio;
        // - Pagos a proveedores
        $cuentas_gasto_servicio = [
            $this->getIdCuenta(6411),
            $this->getIdCuenta(6361),
            $this->getIdCuenta(6363),
            $this->getIdCuenta(6365),
            $this->getIdCuenta(6364),
            $this->getIdCuenta(6351),
            $this->getIdCuenta(6356)
        ];

        $suma_gastos_servicio = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_servicio)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');
        $pagos_proveedores = $suma_gastos_servicio;
        // - Pagos de personal

        $cuentas_gasto_personal = [
            $this->getIdCuenta(621)
        ];

        $suma_gastos_personal = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_personal)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');

        // -Pagos de impuestos
        $cuentas_gasto_impuesto = [
            $this->getIdCuenta(6411)
        ];

        $suma_gastos_impuesto = LibroMayor::whereIn('cuenta_contable_id', $cuentas_gasto_impuesto)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');
        $pagos_impuestos = $suma_gastos_impuesto;

        // flujo efectivo de inversiones
        // Datos:
        // - Compra de activos fijos
        $cuenta_compra_activo_fijo = $this->getIdCuenta(33311);
        $compra_activo_fijo = LibroMayor::where('cuenta_contable_id', $cuenta_compra_activo_fijo)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('debe');
        // - Venta de activos fijos
        $venta_activo_fijo = 0;

        // flujo efectivo de financiamiento
        // Datos:
        // - Aporte de capital
        $cuenta_aporte_capital = $this->getIdCuenta(501);
        $aporte_capital = LibroMayor::where('cuenta_contable_id', $cuenta_aporte_capital)
                                 ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                 ->sum('haber');
        // - Reparto de dividendos
        $reparto_dividendos = 0;
        // - Prestamos
        $prestamos = 0;

        // Calcular flujo efectivo neto
        $flujo_efectivo_operaciones = $cobros_clientes - $pagos_proveedores - $suma_gastos_personal - $pagos_impuestos;
        $flujo_efectivo_inversiones = $venta_activo_fijo - $compra_activo_fijo;
        $flujo_efectivo_financiamiento = $aporte_capital - $reparto_dividendos - $prestamos;

        $flujo_efectivo_neto = $flujo_efectivo_operaciones + $flujo_efectivo_inversiones + $flujo_efectivo_financiamiento;

        $pdf = new Dompdf();
        // estructura del pdf
        // h1 Flujo de Efectivo
        // Periodo: fecha_inicio - fecha_fin
        // tabla con columnas Descripción y Monto
        // 1. Flujo de Efectivo de Operaciones
        // - Cobros de clientes
        // - Pagos a proveedores
        // - Pagos de personal
        // - Pagos de impuestos
        // Total Flujo de Efectivo de Operaciones
        // 2. Flujo de Efectivo de Inversiones
        // - Compra de activos fijos
        // - Venta de activos fijos
        // Total Flujo de Efectivo de Inversiones
        // 3. Flujo de Efectivo de Financiamiento
        // - Aporte de capital
        // - Reparto de dividendos
        // - Prestamos
        // Total Flujo de Efectivo de Financiamiento
        // Flujo de Efectivo Neto

        $pdf->loadHtml('
            <h1>Flujo de Efectivo</h1>
            <p><strong>Periodo:</strong> '.$fecha_inicio.' - '.$fecha_fin.'</p>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 8px; text-align: left;">Descripción</th>
                        <th style="padding: 8px; text-align: right;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px;">Flujo de Efectivo de Operaciones</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Cobros de clientes</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($cobros_clientes, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Pagos a proveedores</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($pagos_proveedores, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Pagos de personal</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($suma_gastos_personal, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Pagos de impuestos</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($pagos_impuestos, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Flujo de Efectivo de Operaciones</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($flujo_efectivo_operaciones, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Flujo de Efectivo de Inversiones</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Compra de activos fijos</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($compra_activo_fijo, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Venta de activos fijos</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($venta_activo_fijo, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Flujo de Efectivo de Inversiones</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($flujo_efectivo_inversiones, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Flujo de Efectivo de Financiamiento</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Aporte de capital</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($aporte_capital, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Reparto de dividendos</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($reparto_dividendos, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">Prestamos</td>
                        <td style="padding: 8px; text-align: right;">'.number_format($prestamos, 2).'</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Total Flujo de Efectivo de Financiamiento</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($flujo_efectivo_financiamiento, 2).'</td>
                    </tr>

                    <tr>
                        <td style="padding: 8px; font-weight: bold;">Flujo de Efectivo Neto</td>
                        <td style="padding: 8px; text-align: right; font-weight: bold;">'.number_format($flujo_efectivo_neto, 2).'</td>
                    </tr>
                </tbody>
            </table>

        ');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('flujo_efectivo.pdf');
    }

    public function getIdCuenta($codigo){
        $cuenta = CuentaContable::where('codigo', $codigo)->first();
        if(!$cuenta){
            dd('La cuenta contable con código '.$codigo.' no existe');
        }
        return $cuenta->id;
    }
}

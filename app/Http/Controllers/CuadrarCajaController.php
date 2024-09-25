<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Venta;
use App\Models\VentaItem;
use App\Models\Comprobante;
use App\Models\ComprobantePago;
use App\Models\Cliente;
use App\Models\Almacen;

use App\Http\Helpers\Prices;
use App\Http\Helpers\Token;
use App\Models\Caja;
use App\Models\EstadoVenta;
use App\Models\FormaPago;
use App\Models\TipoMovimiento;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;

class CuadrarCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
         // usuarios
        // Almacenes

        $usuarios = User::all();
        $almacenes = Almacen::all();

        $datos = $this->procesarDatos($request);

        $datos['usuarios'] = $usuarios;
        $datos['almacenes'] = $almacenes;
        // Construir respuesta específica para index
        return view('ventas.cajas', $datos);

    }

    private function procesarDatos(Request $request) {
        

        // Filtros

        $filtros = $request->input('filtros');
        $accion = $request->input('accion');
       
        $filtro_fecha_desde = null;
        $filtro_fecha_hasta = null;
        $filtro_almacen = null;
        $filtro_usuario = null;

        if (!is_null($filtros)) {
            $filtro_fecha_desde = $request->input('fecha_desde');
            $filtro_fecha_hasta = $request->input('fecha_hasta');
            $filtro_almacen = $request->input('almacen');
            $filtro_usuario = $request->input('usuario');
        }

        // Queries para agrupar y sumar ingresos por tipo

        $query_ingresos_tipos = VentaItem::select(
            DB::raw('CASE WHEN ventas_items.producto_id IS NOT NULL THEN "PRODUCTO" ELSE "SERVICIO" END as tipo'),
            DB::raw('SUM(ventas_items.cantidad) as cantidad'),
            DB::raw('SUM(ventas_items.total) as monto')
        )
        ->join('ventas', 'ventas.id', '=', 'ventas_items.venta_id')
        ->join('users', 'users.id', '=', 'ventas.usuario_id');

        // Queries para agrupar y sumar por medios de pago

        $query_medios_pago = ComprobantePago::select(
            'medio_pago_id',
            DB::raw('SUM(importe) as total_importe'),
            'formas_pagos.FormaDePago as medio_pago_nombre'
        )
        ->join('formas_pagos', 'comprobantes_pagos.medio_pago_id', '=', 'formas_pagos.id')
        ->groupBy('medio_pago_id', 'formas_pagos.FormaDePago');

        // Aplicar filtros

        if ($accion == 'filtrar') {
            if (!is_null($filtro_fecha_desde) && !is_null($filtro_fecha_hasta)) {
                $query_ingresos_tipos->whereBetween(DB::raw('DATE(ventas_items.created_at)'), [$filtro_fecha_desde, $filtro_fecha_hasta]);
                $query_medios_pago->whereBetween(DB::raw('DATE(comprobantes_pagos.created_at)'), [$filtro_fecha_desde, $filtro_fecha_hasta]);
            }

            if (!is_null($filtro_almacen)) {
                $query_ingresos_tipos->whereIn('ventas_items.producto_id', function ($subQuery) use ($filtro_almacen) {
                    $subQuery->select('producto_id')
                        ->from('productos_stocks')
                        ->where('almacen_id', $filtro_almacen);
                });
            }

            if (!is_null($filtro_usuario)) {
                $query_ingresos_tipos->where('users.id', $filtro_usuario);
            }
        }

        // Retornar queries actualizados

        $resumen_ingresos_tipo = $query_ingresos_tipos
            ->groupBy(DB::raw('CASE WHEN producto_id IS NOT NULL THEN "PRODUCTO" ELSE "SERVICIO" END'))
            ->get();

        $resumen_medios_pago = $query_medios_pago->get();

        // Query de los totales de ingresos

        $totales_ingresos_tipo = [
            'cantidad' => 0,
            'monto' => 0.0
        ];

        foreach ($resumen_ingresos_tipo as $item) {
            $totales_ingresos_tipo['cantidad'] += $item->cantidad;
            $totales_ingresos_tipo['monto'] += $item->monto;
        }

        $totales_ingresos_tipo = collect($totales_ingresos_tipo);

        return [
            'resumen_ingresos_tipo' => $resumen_ingresos_tipo,
            'totales_ingresos_tipo' => $totales_ingresos_tipo,
            'resumen_medios_pago' => $resumen_medios_pago,
            'filtros' => [
                'fecha_desde' => $filtro_fecha_desde,
                'fecha_hasta' => $filtro_fecha_hasta,
                'almacen' => $filtro_almacen,
                'usuario' => $filtro_usuario
            ]
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comprobante = Comprobante::with([
            'cliente',
            'cliente.departamento',
            'cliente.provincia',
            'cliente.distrito',
            'venta',
            'venta.items',
            'venta.items.producto',
            'venta.items.servicio',
            'venta.items.mascota',
            'pagos',
            'pagos.medio_pago',
            'pagos.tipo_movimiento'
        ])->find($id);

        $medios_pago = FormaPago::all();

        if (is_null($comprobante)) {
            return view('comprobantes.index');
        }

        return view('comprobantes.edit', ['comprobante' => $comprobante, 'medios_pago' => $medios_pago]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caja $caja)
    {
        $caja->delete();

        return redirect()->back()->with('msg', 'Movimiento de caja eliminado correctamente.');
    }

    // Generar PDF del comprobante

    public function pdf($comprobante_id) {
        $comprobante = Comprobante::with([
            'cliente',
            'cliente.departamento',
            'cliente.provincia',
            'cliente.distrito',
            'venta',
            'venta.items',
            'venta.items.producto',
            'venta.items.servicio',
            'venta.items.mascota',
            'pagos',
            'pagos.medio_pago',
            'pagos.tipo_movimiento'
        ])->find($comprobante_id);

        $valores_venta = (object) [
            'valor_bruto' => 0.0,
            'valor_sin_descuentos' => 0.0,
            'valor_descuentos' => 0.0,
            'valor_con_descuentos' => 0.0,
            'valor_impuestos' => 0.0,
            'valor_total' => 0.0
        ];

        foreach ($comprobante->venta->items as $item) {
            $valores_venta->valor_bruto += $item->subtotal;
            $valores_venta->valor_sin_descuentos += $item->subtotal;
            $valores_venta->valor_con_descuentos += $item->subtotal;
            $valores_venta->valor_impuestos += $item->impuestos;
            $valores_venta->valor_total += ($item->subtotal + $item->impuestos);
        }

        $vista = view('comprobantes.pdf', ['comprobante' => $comprobante, 'valores_venta' => $valores_venta])->render();
        // return  $vista;
        #echo ($vista); exit;

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($vista);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('comprobante.pdf');
    }

    public function pdfCaja(Request $request){
    
        $datos = $this->procesarDatos($request);

        $vista = view('ventas.cuadrarCajaPdf', $datos)->render();
        // return  $vista;
        #echo ($vista); exit;

        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($vista);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('cuadrarCajaPdf.pdf');

    }

    // AJAX

    public function ajax(Request $request) {
        $comprobante_id     = $request->input('comprobante_id');
        $medio_pago_id      = $request->input('medio_pago_id');
        $pago_id            = $request->input('pago_id');
        $monto              = $request->input('monto');
        $motivo             = $request->input('motivo');
        $accion             = $request->input('accion');
        $fecha_hora         = date('Y-m-d H:i:s');

        // Datos del comprobante
        // Datos de la venta

        $comprobante = Comprobante::where('id', $comprobante_id)->first();
        $venta = Venta::where('id', $comprobante->venta_id)->first();

        // Acciones (crear, eliminar)

        if ($accion == 'crear') {
            // Insertar pago en comprobantes_pagos

            $pago_id = ComprobantePago::insertGetId([
                'comprobante_id' => $comprobante_id,
                'medio_pago_id' => $medio_pago_id,
                'tipo_movimiento_id' => TipoMovimiento::VENTA,
                'importe' => $monto,
                'motivo' => $motivo,
                'anulado' => 0,
                'created_at' => $fecha_hora
            ]);

            // Calcular
            // Si $dinero_recibido es igual o supera el total de la venta, la venta pasará a Pagada, caso contrario seguirá en Pendiente
            // En el caso de $saldo_pendiente, es el cálculo del saldo pendiente de pago respecto al total de la venta
            // En el caso de $vuelto, tiene que empezar a sumar si el dinero recibido supera al total de la venta
            // Devolver tipo de movimiento

            $dinero_recibido = (float) ComprobantePago::selectRaw('SUM(importe) as total')->where('anulado', 0)->where('comprobante_id', $comprobante_id)->first()->total;
            $saldo_pendiente = $dinero_recibido < $venta->total ? $venta->total - $dinero_recibido : 0;
            $vuelto = $dinero_recibido < $venta->total ? 0 : abs($dinero_recibido - $venta->total);
            $tipo_movimiento = TipoMovimiento::where('id', TipoMovimiento::VENTA)->pluck('nombre')->first();

            if ($saldo_pendiente == 0) {
                $venta->estado_id = EstadoVenta::PAGADA;
                $venta->update();
            }

            // Actualizar comprobante

            Comprobante::where('id', $comprobante_id)->update([
                'dinero_recibido' => $dinero_recibido,
                'saldo_pendiente' => $saldo_pendiente,
                'vuelto' => $vuelto,
            ]);

            // Actualizar modelo $comprobante

            $comprobante = $comprobante->refresh();

            // Generar un movimiento de caja de entrada

            Caja::insert([
                'transaccion' => Token::create(8, true),
                'descripcion' => 'Movimiento de caja de entrada para la venta #'. str_pad($venta->id, 8, 0, STR_PAD_LEFT),
                'movimiento' => 'entrada',
                'comprobante_id' => $comprobante_id,
                'tipo_movimiento_id' => TipoMovimiento::VENTA,
                'medio_pago_id' => $medio_pago_id,
                'importe_entrada' => $monto,
                'fecha' => $fecha_hora
            ]);

            // Opciones (botón eliminar pago)

            $opciones = '<a href="" class="eliminar-item" data-pago_id="'. $pago_id .'" title="Anular este pago"><i class="fas fa-fw fa-trash"></i></a>';
        }

        if ($accion == 'eliminar') {
            // Anular el pago de comprobantes_pagos

            $pago = ComprobantePago::where('id', $pago_id)->where('comprobante_id', $comprobante_id);

            if ($pago->exists()) {
                $pago = $pago->first();
                $monto = $pago->importe;
                $medio_pago_id = $pago->medio_pago_id;

                // Restar $monto a $dinero_recibido
                // Restar $vuelto a $monto

                $dinero_recibido = $comprobante->dinero_recibido - $monto;
                $saldo_pendiente = $dinero_recibido < $venta->total ? $venta->total - $dinero_recibido : 0;
                $vuelto = $comprobante->vuelto > $monto ? $comprobante->vuelto - $monto : 0;

                // Pasar la venta a Pendiente de pago si $saldo_pendiente ya no es 0

                if ($saldo_pendiente != 0) {
                    $venta->estado_id = EstadoVenta::PENDIENTE;
                    $venta->update();
                }

                // Anular pago

                ComprobantePago::where('id', $pago_id)->update([
                    'anulado' => 1
                ]);

                // Insertar "pago" (anulación del anterior)

                ComprobantePago::insert([
                    'comprobante_id' => $comprobante_id,
                    'medio_pago_id' => $medio_pago_id,
                    'tipo_movimiento_id' => TipoMovimiento::ANULACION,
                    'importe' => $monto,
                    'motivo' => $motivo,
                    'anulado' => 1,
                    'created_at' => $fecha_hora
                ]);

                // Actualizar comprobante

                Comprobante::where('id', $comprobante_id)->update([
                    'dinero_recibido' => $dinero_recibido,
                    'saldo_pendiente' => $saldo_pendiente,
                    'vuelto' => $vuelto,
                ]);

                // Generar un movimiento de caja de salida

                Caja::insert([
                    'transaccion' => Token::create(8, true),
                    'descripcion' => 'Movimiento de caja de salida para la venta #'. str_pad($venta->id, 8, 0, STR_PAD_LEFT),
                    'movimiento' => 'salida',
                    'comprobante_id' => $comprobante_id,
                    'tipo_movimiento_id' => TipoMovimiento::VENTA,
                    'medio_pago_id' => $medio_pago_id,
                    'importe_salida' => $monto,
                    'fecha' => $fecha_hora
                ]);
            }

            // Variables para el front

            $motivo = '—';
            $opciones = '—';
            $tipo_movimiento = TipoMovimiento::where('id', TipoMovimiento::ANULACION)->pluck('nombre')->first();
        }

        // Variables que cambian para el front

        $fecha_hora         = date('d-m-Y H:i:s');
        $medio_pago_nombre  = FormaPago::where('id', $medio_pago_id)->pluck('FormaDePago')->first();
        $monto              = number_format($monto, 2, ',', '');
        $dinero_recibido    = number_format($dinero_recibido, 2, ',', '');
        $saldo_pendiente    = number_format($saldo_pendiente, 2, ',', '');
        $vuelto             = number_format($vuelto, 2, ',', '');

        // Retornar datos

        $data = [
            'fecha_hora' => $fecha_hora,
            'medio_pago' => $medio_pago_nombre,
            'monto' => '<span class="'. ($accion == 'crear' ? 'text-success' : 'text-danger') .'">'. Prices::symbol() .' '. $monto .'</span>',
            'motivo' => $motivo,
            'dinero_recibido' => $dinero_recibido,
            'saldo_pendiente' => $saldo_pendiente,
            'vuelto' => $vuelto,
            'tipo_movimiento' => $tipo_movimiento,
            'opciones' => $opciones,
        ];

        return response()->json($data);
    }
}

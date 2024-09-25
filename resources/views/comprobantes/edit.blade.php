@extends('adminlte::page')
@section('title', 'VetSys|Comprobantes')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-dolly-flatbed"></i> Comprobantes</h1>
@stop

@php
$heads = [
    'Item',
    'Tipo',
    'Valor Unitario',
    'Cantidad',
    'Subtotal',
    'Impuestos',
    'Total',
    'Mascota',
];
$heads_pagos = [
    'Fecha',
    'Medio de pago',
    'Monto',
    'Motivo',
    'Movimiento',
    'Opciones'
];
$config = [
    'language' => [
        'url' => '',
    ],
    'bPaginate' => false
];
@endphp

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Editar comprobante N° {{ str_pad($comprobante->serie, 3, '0', STR_PAD_LEFT) }}-{{ str_pad($comprobante->comprobante, 8, '0', STR_PAD_LEFT) }} - {{ $comprobante->tipoComprobante->nombre }}</h3>
    </div>
    <form action="{{ url('cajas') }}" method="post">
        @csrf
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class=" d-md-flex justify-content-md-end">
                        <a href="{{ route('comprobantes.pdf', $comprobante->id) }}" id="generar-pdf" class="btn btn-primary btn-sm" ><i class="fas fa-fw fa-file-pdf"></i> Generar PDF</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h5 class="d-block">Cliente</h5>
                </div>

                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="cliente" value="{{ $comprobante->cliente->Nombre }} {{ $comprobante->cliente->Apellido }}" placeholder="" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-fw fa-id-card"></i></span>
                        </div>
                        <input type="number" class="form-control form-control-sm" name="documento_identidad" value="{{ $comprobante->cliente->DocumentoIdentidad }}" placeholder="" min="0" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                        </div>
                        <input type="date" class="form-control form-control-sm" name="fecha_nacimiento" value="{{ $comprobante->cliente->FechaNacimiento }}" placeholder="" min="0" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-at"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="email" value="{{ $comprobante->cliente->Email }}" placeholder="" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="departamento" value="{{ $comprobante->cliente->departamento->Departamento }}" placeholder="" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="provincia" value="{{ $comprobante->cliente->provincia->Provincia }}" placeholder="" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="distrito" value="{{ $comprobante->cliente->distrito->Distrito }}" placeholder="" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="direccion" value="{{ $comprobante->cliente->Direccion }}" placeholder="" readonly>
                    </div>
                </div>
            </div>

            <div class="mt-4 row">
                <div class="col-md-12">
                    <h5 class="d-block">Venta</h5>

                    <x-adminlte-datatable id="tabla-items" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify :config="$config">
                        @foreach ($comprobante->venta->items as $item)
                            <tr>
                                <td>{!! !is_null($item->servicio_id) ? ($item->servicio->Servicio ?? '<span class="text-danger">Servicio no encontrado</span>') : ($item->producto->Producto ?? '<span class="text-danger">Producto no encontrado</span>') !!}</td>
                                <td>{{ !is_null($item->servicio_id) ? 'Servicio' : 'Producto' }}</td>
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-unitario">{{ number_format(($item->subtotal / $item->cantidad), 2, ',', '') }}</span></td>
                                <td>x <span class="unidades-item">{{ intval($item->cantidad) }}</span> u.</td>
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-subtotal">{{ number_format($item->subtotal, 2, ',', '') }}</span></td>
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-impuestos">{{ number_format($item->impuestos, 2, ',', '') }}</span></td>
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-total">{{ number_format($item->total, 2, ',', '') }}</span></td>
                                <td>{!! $item->mascota->Mascota ?? '<span class="text-danger">Sin mascota</span>' !!}</td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>

                    <div id="totales">
                        <ul>
                            <li><div>Valor de venta bruto (sin descuentos)</div><div>{{ Prices::symbol() }} <span class="valor-venta-sin-descuentos">0.00</span></div></li>
                            <li><div>Total descuentos</div><div>{{ Prices::symbol() }} <span class="valor-total-descuentos">0,00</span></div></li>
                            <li><div>Valor de venta (con descuentos)</div><div>{{ Prices::symbol() }} <span class="valor-venta-con-descuentos">0,00</span></div></li>
                            <li><div>Impuestos</div><div>{{ Prices::symbol() }} <span class="valor-impuestos">0,00</span></div></li>
                            <li><div>TOTAL FINAL</div><div>{{ Prices::symbol() }} <span class="valor-total">0,00</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-4 row">
                <div class="col-md-12">
                    <h5 class="d-block">Pagos</h5>

                    <div class="row justify-content-end d-flex text-right inputs-pagos">
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-fw fa-credit-card"></i></span>
                                </div>
                                <select class="form-control form-control-sm" name="medio_pago_id" required>
                                    <option value="" disabled selected>Seleccionar...</option>

                                    @foreach ($medios_pago as $medio_pago)
                                        <option value="{{ $medio_pago->id }}">{{ $medio_pago->FormaDePago }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-fw fa-dollar-sign"></i></span>
                                </div>
                                <input type="number" class="form-control form-control-sm" name="monto" value="{{old('monto')}}" placeholder="* Monto" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-fw fa-sticky-note"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-sm" name="motivo" value="{{old('motivo')}}" placeholder="Motivo (opcional)">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button id="agregar-pago" class="btn btn-success btn-sm" disabled>
                                <span class="text">
                                    <i class="fas fa-fw fa-plus"></i> Agregar Pago
                                </span>

                                <span class="spinner">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <x-adminlte-datatable id="tabla-pagos" :heads="$heads_pagos" head-theme="light" striped hoverable bordered compressed beautify :config="$config">
                                @if ($comprobante->pagos->isNotEmpty())
                                    @foreach ($comprobante->pagos as $pago)
                                        <tr>
                                            <td>{{ $pago->created_at }}</td>
                                            <td>{{ $pago->medio_pago->FormaDePago }}</td>
                                            <td class="{{ $pago->tipo_movimiento_id == 3 ? 'text-danger' : 'text-success' }}">{{ Prices::symbol() }} {{ number_format($pago->importe, 2, ',', '') }}</td>
                                            <td>{{ $pago->motivo ?? '—' }}</td>
                                            <td>{{ $pago->tipo_movimiento->nombre }}</td>
                                            <td>
                                                @if (!$pago->anulado)

                                                    <a href="" class="eliminar-item" data-pago_id="{{ $pago->id }}" title="Anular este pago">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </a>

                                                @else

                                                    —

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </x-adminlte-datatable>

                            <div id="pagos">
                                <ul>
                                    <li><div>Dinero recibido</div><div>{{ Prices::symbol() }} <span class="valor-dinero-recibido">{{ number_format($comprobante->dinero_recibido, 2, ',', '') }}</span></div></li>
                                    <li><div>Saldo pendiente</div><div>{{ Prices::symbol() }} <span class="valor-saldo-pendiente">{{ number_format($comprobante->saldo_pendiente, 2, ',', '') }}</span></div></li>
                                    <li><div>Cambio / vuelto</div><div>{{ Prices::symbol() }} <span class="valor-vuelto">{{ number_format($comprobante->vuelto, 2, ',', '') }}</span></div></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="avisos">
                        <div class="mt-3 alert alert-success d-none" role="alert"></div>
                        <div class="mt-3 alert alert-danger d-none" role="alert"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    <div class=" d-md-flex justify-content-md-end">
                        <a href="{{url('cajas')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-fw fa-undo-alt"></i> Regresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="post"></div>
        <input id="comprobante-id" type="hidden" value="{{ $comprobante->id }}">
    </form>
</div>

@stop

@push('js')
<script>
    $(document).ready(function() {
        let agregar_pago = $('#agregar-pago');
        let comprobante_id = $('#comprobante-id').val();
        let avisos = $('#avisos');
        let avisos_exito = avisos.find('.alert-success');
        let avisos_error = avisos.find('.alert-danger');

        // Inputs de los pagos ingresados

        (function() {
            let inputs_pagos = $('.inputs-pagos').find('input, select');

            inputs_pagos.on('input', function() {
                let completo = false;
                let pendientes = true;
                let valores = [];

                inputs_pagos.each(function() {
                    let input = $(this).val();
                    let required = $(this).prop('required');

                    if (required) {
                        valores.push(input);
                    }
                });

                pendientes = valores.some(element => element === undefined || element === null || element === '');

                if (!pendientes) {
                    completo = true;
                }

                if (completo) {
                    agregar_pago.prop('disabled', false);
                }

                if (!completo) {
                    agregar_pago.prop('disabled', true);
                }
            });
        })();

        // Agregar fila a tabla de pagos hechos

        (function() {
            let tabla_pagos = $('#tabla-pagos').DataTable();
            let data, fila_pago;

            agregar_pago.on('click', function() {
                let medio_pago_id = $(this).parents('.row').find('select[name="medio_pago_id"] option:selected').val();
                let monto = $(this).parents('.row').find('input[name="monto"]').val();
                let motivo = $(this).parents('.row').find('input[name="motivo"]').val();

                let texto_valor_dinero_recibido = $('.valor-dinero-recibido');
                let texto_valor_saldo_pendiente = $('.valor-saldo-pendiente');
                let texto_valor_vuelto = $('.valor-vuelto');

                avisos_exito.addClass('d-none');
                avisos_error.addClass('d-none');

                if (motivo == '') {
                    motivo = '—';
                }

                data = {
                    comprobante_id: comprobante_id,
                    medio_pago_id: medio_pago_id,
                    monto: monto,
                    motivo: motivo,
                    accion: 'crear'
                }

                $.ajax({
                    url: "{{ route('comprobantes.ajax') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        agregar_pago.prop('disabled', true);
                        agregar_pago.find('.spinner').show();
                        agregar_pago.find('.text').hide();
                    }
                })
                .done(function(response) {
                    fila_pago = [response.fecha_hora, response.medio_pago, response.monto, response.motivo, response.tipo_movimiento, response.opciones];
                    tabla_pagos.row.add(fila_pago).draw();

                    texto_valor_dinero_recibido.text(response.dinero_recibido);
                    texto_valor_saldo_pendiente.text(response.saldo_pendiente);
                    texto_valor_vuelto.text(response.vuelto);

                    avisos_exito.html('El pago de '+ response.monto.replace(/<\/?[^>]+(>|$)/g, "") +' con motivo '+ response.motivo +' fue ingresado correctamente.').removeClass('d-none');
                })
                .fail(function(xhr, status, error) {
                    avisos_error.html('No se pudo ingresar el pago debido a un error.').removeClass('d-none');
                })
                .always(function() {
                    agregar_pago.prop('disabled', false);
                    agregar_pago.find('.spinner').hide();
                    agregar_pago.find('.text').show();
                });

                return false;
            });
        })();

        // Anular un pago

        (function() {
            let tabla_pagos = $('#tabla-pagos').DataTable();
            let anular_pago = '.eliminar-item';

            $(document).on('click', anular_pago, function() {
                if (confirm('Esta operación anulará el pago y generará un movimiento de caja de salida. ¿Continuar?')) {
                    let btn = $(this);
                    let pago_id = $(this).data('pago_id');

                    let texto_valor_dinero_recibido = $('.valor-dinero-recibido');
                    let texto_valor_saldo_pendiente = $('.valor-saldo-pendiente');
                    let texto_valor_vuelto = $('.valor-vuelto');

                    avisos_exito.addClass('d-none');
                    avisos_error.addClass('d-none');

                    data = {
                        comprobante_id: comprobante_id,
                        pago_id: pago_id,
                        accion: 'eliminar'
                    }

                    $.ajax({
                        url: "{{ route('comprobantes.ajax') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        beforeSend: function() {

                        }
                    })
                    .done(function(response) {
                        fila_pago = [response.fecha_hora, response.medio_pago, response.monto, response.motivo, response.tipo_movimiento, response.opciones];
                        tabla_pagos.row.add(fila_pago).draw();

                        texto_valor_dinero_recibido.text(response.dinero_recibido);
                        texto_valor_saldo_pendiente.text(response.saldo_pendiente);
                        texto_valor_vuelto.text(response.vuelto);

                        btn.html('—');

                        avisos_error.html('El pago de '+ response.monto.replace(/<\/?[^>]+(>|$)/g, "") +' fue anulado correctamente.').removeClass('d-none');
                    })
                    .fail(function(xhr, status, error) {
                        avisos_error.html('No se pudo ingresar el pago debido a un error.').removeClass('d-none');
                    });
                }

                return false;
            });
        })();

        // Generar PDF

        (function() {
            let generar_pdf = $('#generar-pdf');

            generar_pdf.on('click', function() {
                let $this = $(this);

                setTimeout(function() {
                    $this.addClass('disabled');
                    $this.removeAttr('href');
                }, 50);
            });

            $(window).on('beforeunload', function() {
                generar_pdf.html('<i class="fas fa-fw fa-file-pdf"></i> Generando...');
            });
        })();

        // Calcular totales

        calcularTotales();

        // Función - Calcular totales

        function calcularTotales() {
            let tabla_items                 = $('#tabla-items');
            let totales                     = $('#totales');

            let valor_venta_sin_descuentos  = totales.find('.valor-venta-sin-descuentos');
            let valor_total_descuentos      = totales.find('.valor-total-descuentos');
            let valor_venta_con_descuentos  = totales.find('.valor-venta-con-descuentos');
            let valor_impuestos             = totales.find('.valor-impuestos');
            let valor_total                 = totales.find('.valor-total');

            let sum_subtotales  = 0.0;
            let sum_impuestos   = 0.0;
            let sum_totales     = 0.0;

            tabla_items.find('tbody tr').each(function() {
                let valores_texto   = $(this).find('td span');

                valores_texto.each(function(index) {
                    let valor_texto = $(this).text().replace(',', '.');

                    if (index === 2) {
                        sum_subtotales += parseFloat(valor_texto);
                    }

                    if (index === 3) {
                        sum_impuestos += parseFloat(valor_texto);
                    }

                    if (index === 4) {
                        sum_totales += parseFloat(valor_texto);
                    }
                });
            });

            sum_subtotales = sum_subtotales.toFixed(2).replace('.', ',');
            sum_impuestos = sum_impuestos.toFixed(2).replace('.', ',');
            sum_totales = sum_totales.toFixed(2).replace('.', ',');

            valor_venta_sin_descuentos.text(sum_subtotales);
            valor_venta_con_descuentos.text(sum_subtotales);
            valor_impuestos.text(sum_impuestos);
            valor_total.text(sum_totales);
        }
    });
</script>

<style>
    #agregar-pago .text {
        display: block;
    }

    #agregar-pago .spinner {
        display: none;
    }

    #tabla-pagos_wrapper .row:first-child,
    #tabla-pagos_wrapper .row:last-child,
    #tabla-items_wrapper .row:first-child,
    #tabla-items_wrapper .row:last-child {
        display: none;
    }

    #pagos ul,
    #totales ul {
        margin-bottom: 0;
        text-align: right;
        list-style: none;
    }

        #totales ul li:last-child {
            font-weight: 700;
        }

        #pagos ul li,
        #totales ul li {
            display: grid;
            grid-template-columns: 1fr 100px;
            gap: 15px;
        }
</style>
@endpush

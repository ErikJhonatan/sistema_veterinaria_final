@extends('adminlte::page')
@section('title', 'VetSys|Ventas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-dolly-flatbed"></i> Ventas</h1>
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
        'Opciones'
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
];
@endphp

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Crear Venta</h3>
    </div>
    <form action="{{ url('ventas') }}" method="post">
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

            <div class="mb-4 row">
                <div class="col-md-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <a href="{{url('cliente/create')}}" class="btn btn-info btn-sm btn-crear">Crear Cliente</a>
                        </div>

                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <a href="{{url('mascota/create')}}" class="btn btn-info btn-sm btn-crear">Crear Mascota</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-md-6">
                    <div class="input-group">
                        <select class="form-control form-control-sm" id="lista-clientes" name="cliente">
                            <option value="" disabled selected>* Cliente...</option>

                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->Nombre .' '. $cliente->Apellido }} | {{ $cliente->DocumentoIdentidad }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <a href="" id="seleccionar-cliente" class="btn btn-info btn-sm">Seleccionar Cliente</a>
                </div>
            </div>

            <div id="items" class="mt-4 d-none">
                <div class="row" >
                    <div class="col-md-3">
                        <div class="input-group">
                            <select class="form-control form-control-sm" id="lista-almacenes" name="almacen_id">
                                <option value="" disabled selected>* Almacén...</option>

                                @foreach ($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control form-control-sm" id="lista-items" name="item" disabled>
                                        <option value="" disabled selected>* Item...</option>

                                        @foreach ($items as $item)
                                            @php

                                            $stocks = '';

                                            if ($item->stocks) {
                                                $stocks = [];

                                                foreach ($item->stocks as $stock) {
                                                    $stocks[$stock->almacen_id] = $stock->cantidad;
                                                }

                                                $stocks = json_encode($stocks);
                                            }

                                            @endphp

                                            <option value="{{ $item->id }}" data-precio-unitario="{{ $item->PrecioVenta ?? $item->PrecioServicio }}" data-tipo="{{ isset($item->Producto) ? 'producto' : 'servicio' }}" data-stocks="{{ $stocks }}" data-nombre_original="{{ $item->Producto ?? $item->Servicio }}">{{ $item->Producto ?? $item->Servicio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <a href="" id="seleccionar-item" class="btn btn-info btn-sm">Seleccionar Item</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control form-control-sm" name="tipo_comprobante_id">
                                <option value="" disabled>* Tipo de Comprobante...</option>
                                @foreach ($tiposComprobantes as $tipo)
                                    <option value="{{ $tipo->id }}" {{ $tipo->id == 1 ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3 row">
                    <div class="col-md-12">
                        <x-adminlte-datatable id="tabla-items" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify :config="$config">
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
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-grid gap-3 d-md-block">
                        <button type="submit" class="btn bg-gradient-primary btn-sm btn-accion" disabled><i class="fas fa-fw fa-save"></i> Crear Venta</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class=" d-md-flex justify-content-md-end">
                        <a href="{{url('ventas')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-fw fa-undo-alt"></i> Regresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="post">
            <input type="hidden" name="cliente_id">
        </div>
    </form>
</div>

<select class="d-none" id="lista-global-mascotas">

    @foreach ($mascotas as $mascota)
        <option value="{{ $mascota->id }}" data-cliente_id="{{ $mascota->idCliente }}">{{ $mascota->Mascota }}</option>
    @endforeach

</select>

@stop

@push('js')
<script>
    $(document).ready(function() {
        // Lista de clientes (select2)
        // Lista de ítems (select2)
        // Lista de almacenes (select2)

        $('#lista-clientes').select2();
        $('#lista-items').select2();
        $('#lista-almacenes').select2();

        // Seleccionar / remover cliente
        // Seleccionar ítem
        // Eliminar ítem
        // Aumentar o disminuir unidad de ítem
        // Crear mascota/cliente

        (function() {
            let tabla_items             = $('#tabla-items');
            let mascotas                = $('#lista-global-mascotas');
            let btn_accion              = $('.btn-accion');

            let input_cliente_id        = $('#post input[name="cliente_id"]');

            let el_empty                = '<tr><td valign="top" colspan="9" class="dataTables_empty">Ningún dato disponible en esta tabla</td></tr>';
            let el_td_items             = 'tbody tr td:first-child';
            let el_seleccionar_cliente  = '#seleccionar-cliente';
            let el_seleccionar_item     = '#seleccionar-item';
            let el_eliminar_item        = '.eliminar-item';
            let el_btn_crear            = '.btn-crear';
            let el_unidades_item        = '.unidades-item';
            let el_mascota_item         = '.mascota-item';
            let el_precio_unitario      = '.precio-unitario';
            let el_precio_subtotal      = '.precio-subtotal';
            let el_precio_impuestos     = '.precio-impuestos';
            let el_precio_total         = '.precio-total';

            let cantidad_items;

            // Seleccionar / remover cliente

            $(document).on('click', el_seleccionar_cliente, function() {
                let btn = $(this);
                let cliente = $('#lista-clientes');
                let items = $('#items');
                let clicked = false;

                if (cliente.val() === null) {
                    alert('Por favor seleccione un cliente del listado.');

                    return false;
                }

                btn.data('clicked', !btn.data('clicked'));
                clicked = $(this).data('clicked');

                if (clicked) {
                    btn.addClass('btn-danger').removeClass('btn-info');
                    btn.text('Remover Cliente');
                    items.removeClass('d-none');

                    input_cliente_id.val(cliente.val());
                }

                if (!clicked) {
                    btn.addClass('btn-info').removeClass('btn-danger');
                    btn.text('Seleccionar Cliente');
                    items.addClass('d-none');

                    cliente.val(null).trigger('change');
                    tabla_items.find('tbody').html(el_empty);
                    btn_accion.prop('disabled', true);

                    input_cliente_id.val('');
                }

                return false;
            });

            // Seleccionar item

            $(document).on('click', el_seleccionar_item, function() {
                let btn = $(this);
                let item = $('#lista-items');
                let cliente_id = input_cliente_id.val();

                let item_seleccionado = item.find('option:selected');
                let item_nombre = item_seleccionado.text();
                let item_id = item_seleccionado.val();
                let item_tipo = item_seleccionado.data('tipo');
                let item_stock = item_seleccionado.data('stock');
                let item_almacen = item_seleccionado.data('almacen');
                let precio_unitario = parseFloat(item_seleccionado.data('precio-unitario'));
                let precio_impuestos = parseFloat(calcularPorcentaje(precio_unitario, 18));
                let precio_total = precio_unitario + precio_impuestos;

                let fila, mascota_id;
                let valido = true;

                if (item.val() === null) {
                    alert('Por favor seleccione un ítem del listado.');
                    valido = false;
                }

                tabla_items.find(el_td_items).each(function() {
                    if ($(this).text() === item_nombre) {
                        alert('El ítem seleccionado ya existe, por favor elija otro.');
                        valido = false;
                    }
                });

                if (valido) {
                    item.val(null).trigger('change');

                    if (tabla_items.find('.dataTables_empty').length) {
                        tabla_items.find('tbody').html('');
                    }

                    fila += '<tr data-item="'+ item_id +'" data-tipo="'+ item_tipo +'">';
                        fila += '<td width="20%">';
                            fila += item_nombre;
                        fila += '</td>';
                        fila += '<td style="text-transform: capitalize;">';
                            fila += item_tipo;
                        fila += '</td>';
                        fila += '<td>';
                            fila += '{{ Prices::symbol() }} <span class="precio-item precio-unitario">'+ precio_unitario.toFixed(2).replace('.', ',') +'</span>';
                        fila += '</td>';
                        fila += '<td width="5%">';
                            fila += '<input class="form-control form-control-sm unidades-item" type="number" min="0" value="1" max="'+ item_stock +'">';
                        fila += '</td>';
                        fila += '<td>';
                            fila += '{{ Prices::symbol() }} <span class="precio-item precio-subtotal">'+ precio_unitario.toFixed(2).replace('.', ',') +'</span>';
                        fila += '</td>';
                        fila += '<td>';
                            fila += '{{ Prices::symbol() }} <span class="precio-item precio-impuestos">'+ precio_impuestos.toFixed(2).replace('.', ',') +'</span>';
                        fila += '</td>';
                        fila += '<td>';
                            fila += '{{ Prices::symbol() }} <span class="precio-item precio-total">'+ precio_total.toFixed(2).replace('.', ',') +'</span>';
                        fila += '</td>';
                        fila += '<td>';
                            fila += '<select class="form-control form-control-sm mascota-item">';
                                fila += '<option value="">Ninguna</option>';

                                mascotas.find('option').each(function(index) {
                                    if ($(this).data('cliente_id') == cliente_id) {
                                        if (mascota_id === undefined) {
                                            mascota_id = $(this).val();
                                        }

                                        fila += '<option value="'+ $(this).val() +'">';
                                            fila += $(this).text();
                                        fila += '</option>';
                                    }
                                });

                            fila += '</select>';
                        fila += '</td>';
                        fila += '<td>';
                            fila += '<a href="" class="eliminar-item" title="Eliminar este ítem"><i class="fas fa-fw fa-trash"></i></a>';

                            fila += '<div class="inputs">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][id]" value="'+ item_id +'">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][tipo]" value="'+ item_tipo +'">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][mascota_id]" value="'+ mascota_id +'">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][almacen_id]" value="'+ item_almacen +'">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][subtotal]" value="">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][cantidad]" value="1">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][impuestos]" value="">';
                                fila += '<input type="hidden" name="item['+ item_tipo +']['+ item_id +'][total]" value="">';
                            fila += '</div>';
                        fila += '</td>';
                    fila += '</tr>';

                    tabla_items.find('tbody').append(fila);
                    cantidad_items = tabla_items.find('tbody tr').length;
                }

                if (cantidad_items > 0) {
                    btn_accion.prop('disabled', false);
                }

                if (cantidad_items === 0) {
                    btn_accion.prop('disabled', true);
                }

                calcularTotales();

                return false;
            });

            // Aumentar / disminuir unidades

            $(document).on('input', el_unidades_item, function() {
                let fila = $(this).parents('tr');
                let unidades = $(this).val();
                let precio_unitario = fila.find(el_precio_unitario);
                let precio_subtotal = fila.find(el_precio_subtotal);
                let precio_impuestos = fila.find(el_precio_impuestos);
                let precio_total = fila.find(el_precio_total);

                let val_unidades = parseInt(unidades);
                let val_precio_unitario = parseFloat(precio_unitario.text().replace(',', '.'));
                let val_precio_subtotal = parseFloat(precio_subtotal.text().replace(',', '.'));
                let val_precio_impuestos = parseFloat(precio_impuestos.text().replace(',', '.'));
                let val_precio_total = parseFloat(precio_total.text().replace(',', '.'));

                let sum_subtotal = val_precio_unitario * val_unidades;
                let sum_impuestos = calcularPorcentaje(sum_subtotal, 18);
                let sum_total = sum_subtotal + sum_impuestos;

                precio_subtotal.text(sum_subtotal.toFixed(2).replace('.', ','));
                precio_impuestos.text(sum_impuestos.toFixed(2).replace('.', ','));
                precio_total.text(sum_total.toFixed(2).replace('.', ','));

                calcularTotales();
            });

            // Eliminar ítem

            $(document).on('click', el_eliminar_item, function() {
                let btn = $(this);
                let fila = $(this).parents('tr');

                fila.fadeOut('fast', function() {
                    $(this).remove();

                    cantidad_items = tabla_items.find('tbody tr').length;

                    if (cantidad_items === 0) {
                        tabla_items.find('tbody').html(el_empty);
                        btn_accion.prop('disabled', true);
                    }

                    calcularTotales();
                });

                return false;
            });

            // Cambiar mascota del ítem

            $(document).on('change', el_mascota_item, function() {
                let parent = $(this).parents('tr');
                let select = $(this);
                let item_id = parent.data('item');
                let item_tipo = parent.data('tipo');
                let mascota_id = select.val();

                parent.find('.inputs input[name="item['+ item_tipo +']['+ item_id +'][mascota_id]"]').val(mascota_id);
            });

            // Crear mascota / cliente

            $(document).on('click', el_btn_crear, function() {
                if (confirm('Va a abandonar esta página y toda la información cargada se perderá. ¿Continuar?')) {
                    return true;
                }

                return false;
            });
        })();

        // Seleccionar un almacén

        (function() {
            let lista_almacenes = $('#lista-almacenes');
            let lista_items = $('#lista-items');

            lista_almacenes.on('change', function() {
                let almacen_id = $(this).val();

                lista_items.prop('disabled', false);
                lista_items.find('option').each(function() {
                    let item = $(this);
                    let stocks = item.data('stocks');
                    let tipo = item.data('tipo');

                    item.prop('disabled', false);

                    if (stocks !== undefined && tipo == 'producto') {
                        item.text(item.data('nombre_original') +' ('+ stocks[almacen_id] +' u.)');
                        item.data('stock', stocks[almacen_id]);
                        item.data('almacen', almacen_id);

                        if (stocks[almacen_id] == 0) {
                            item.prop('disabled', true);
                        }
                    }
                });

                $('#lista-items').select2();
            });
        })();

        // Calcular totales

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
                let unidades        = $(this).find('td .unidades-item').val();
                let inputs          = $(this).find('.inputs input');

                let sum_fila_subtotales  = 0.0;
                let sum_fila_impuestos   = 0.0;
                let sum_fila_totales     = 0.0;

                valores_texto.each(function(index) {
                    let valor_texto = $(this).text().replace(',', '.');

                    if (index === 1) {
                        sum_subtotales += parseFloat(valor_texto);
                        sum_fila_subtotales += parseFloat(valor_texto);
                    }

                    if (index === 2) {
                        sum_impuestos += parseFloat(valor_texto);
                        sum_fila_impuestos += parseFloat(valor_texto);
                    }

                    if (index === 3) {
                        sum_totales += parseFloat(valor_texto);
                        sum_fila_totales += parseFloat(valor_texto);
                    }
                });

                inputs.each(function(index) {
                    let name = $(this).prop('name');

                    if (index === 4) {
                        $(this).val(sum_fila_subtotales);
                    }

                    if (index === 5) {
                        $(this).val(unidades);
                    }

                    if (index === 6) {
                        $(this).val(sum_fila_impuestos);
                    }

                    if (index === 7) {
                        $(this).val(sum_fila_totales);
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

        // Calcular porcentaje

        function calcularPorcentaje(numero, porciento) {
            return (numero * porciento) / 100;
        }
    });
</script>

<style>
    #items .select2-container {
        width: 100% !important;
    }

    #tabla-items_wrapper .row:first-child,
    #tabla-items_wrapper .row:last-child {
        display: none;
    }

    #totales ul {
        margin-bottom: 0;
        text-align: right;
        list-style: none;
    }

        #totales ul li:last-child {
            font-weight: 700;
        }

        #totales ul li {
            display: grid;
            grid-template-columns: 1fr 100px;
            gap: 15px;
        }
</style>
@endpush

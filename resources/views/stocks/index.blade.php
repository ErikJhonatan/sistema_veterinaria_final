@extends('adminlte::page')

@section('title', 'VetSys | Stocks')

@php
$heads = [
    'Fecha de Registro' ,
    'ID de producto',
    'Nombre',
    'Cantidad',
    'Opciones'
];
$heads_stocks = [
    'Almacén',
    'Stock',
    'Opciones'
];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-sign-in-alt"></i> Stocks</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Stocks</h3>
    </div>
    <div class="card-body">
        @if (session('msg'))
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <x-adminlte-alert theme="success" id='success-alert' title="" dismissable>
                    {{session('msg')}}
                    </x-adminlte-alert>
                </div>
            </div>
        @endif

        <hr>

        <div class="row">
            <x-adminlte-datatable id="tabla-productos" class="tabla-productos" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify with-buttons :config="$config">
                @foreach ($productos as $producto)
                    <tr class="position-relative">
                        <td>{{\Carbon\Carbon::parse($producto->created_at)->format('Y-m-d H:i:s')}}</td>
                        <td>
                            {{ $producto->id }}
                        </td>
                        <td>
                            {{ $producto->Producto }}
                        </td>
                        <td>
                            @foreach($producto->stocks as $stock)
                                <span class="badge badge-info">{{ $stock->almacen->nombre }}: {{ $stock->cantidad }}</span>
                            @endforeach
                        </td>
                        <td>
                            <button type="submit" class="editar-item" title="Editar {{ $producto->Producto }}" data-id="{{ $producto->id }}">
                                <i class="fas fa-fw fa-bolt"></i>
                            </button>

                            <table class="quick-table position-absolute">
                                <tr>
                                    <td colspan="4" class="p-3">
                                        <x-adminlte-datatable id="tabla-stocks-{{ $producto->id }}" class="tabla-stocks" :heads="$heads_stocks" head-theme="light" striped hoverable bordered compressed beautify :config="$config">
                                            @if ($producto->stocks->isNotEmpty())
                                                @foreach ($producto->stocks as $stock)
                                                    <tr>
                                                        <td>{{ $stock->almacen->nombre }}</td>
                                                        <td width="30%">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="fas fa-fw fa-hashtag"></i></span>
                                                                        </div>
                                                                        <input type="number" class="form-control form-control-sm" name="cantidad" value="{{ $stock->cantidad }}" placeholder="* Cantidad" min="0" step="1" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <button class="btn btn-success btn-sm modificar-stock w-100" data-stock_id="{{ $stock->id }}">
                                                                        <span class="text">
                                                                            <i class="fas fa-fw fa-pen"></i> Modificar
                                                                        </span>

                                                                        <span class="spinner">
                                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><span class="eliminar-stock" data-stock_id="{{ $stock->id }}" title="Eliminar stock"><i class="fa fa-fw fa-trash"></i></span></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </x-adminlte-datatable>

                                        <div class="row inputs-stocks mt-2">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-fw fa-warehouse"></i></span>
                                                    </div>
                                                    <select class="form-control form-control-sm" name="almacen_id" required>
                                                        <option value="" disabled selected>Seleccionar...</option>

                                                        @foreach ($almacenes as $almacen)
                                                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-fw fa-hashtag"></i></span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm" name="cantidad" value="" placeholder="* Cantidad" min="0" step="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-success btn-sm agregar-stock" data-producto_id="{{ $producto->id }}" disabled>
                                                    <span class="text">
                                                        <i class="fas fa-fw fa-plus"></i> Agregar Stock
                                                    </span>

                                                    <span class="spinner">
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
    $(document).ready(function() {
        let agregar_stock   = $('.agregar-stock');
        let modificar_stock = '.modificar-stock';
        let eliminar_stock  = '.eliminar-stock';

        // Edición rápida de ítems

        (function() {
            let editar_item = $('.editar-item');

            editar_item.on('click', function() {
                let btn = $(this).find('i');
                let quick_table = $(this).next();
                let alto_fila = quick_table.outerHeight();

                $('.quick-table').fadeOut();
                $('.editar-item').find('i').addClass('fa-bolt').removeClass('fa-times');

                if (quick_table.is(':visible')) {
                    quick_table.fadeOut();
                    btn.addClass('fa-bolt').removeClass('fa-times');
                } else {
                    quick_table.fadeIn();
                    btn.removeClass('fa-bolt').addClass('fa-times');
                }

                return false;
            });
        })();

        // Inputs de los stocks ingresados

        (function() {
            let inputs_stocks = $('.inputs-stocks').find('input, select');

            inputs_stocks.on('input', function() {
                let inputs = $(this).parents('.inputs-stocks').find('input, select');
                let btn_agregar = $(this).parents('.inputs-stocks').find('.agregar-stock');

                let completo = false;
                let pendientes = true;
                let valores = [];

                inputs.each(function() {
                    let input = $(this).val();

                    valores.push(input);
                });

                pendientes = valores.some(element => element === undefined || element === null || element === '');

                if (!pendientes) {
                    completo = true;
                }

                if (completo) {
                    btn_agregar.prop('disabled', false);
                }

                if (!completo) {
                    btn_agregar.prop('disabled', true);
                }
            });
        })();

        // Agregar fila a tabla de stocks

        (function() {
            agregar_stock.on('click', function() {
                let btn_agregar = $(this);
                let producto_id = $(this).data('producto_id');
                let almacen_id = $(this).parents('.inputs-stocks').find('select').val();
                let cantidad = $(this).parents('.inputs-stocks').find('input').val();

                let tabla_stocks = $(this).parents('.row').prev().find('#tabla-stocks-'+ producto_id).DataTable();
                let data, fila_stock;

                data = {
                    producto_id: producto_id,
                    almacen_id: almacen_id,
                    cantidad: cantidad,
                    accion: 'agregar'
                }

                $.ajax({
                    url: "{{ route('stocks.ajax') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        btn_agregar.prop('disabled', true);
                        btn_agregar.find('.spinner').show();
                        btn_agregar.find('.text').hide();
                    }
                })
                .done(function(response) {
                    if (response.existencia) {
                        alert('Este almacén ya fue asignado para este producto.');
                        return false;
                    }

                    if (!response.existencia) {
                        fila_stock = [response.almacen, response.cantidad, response.opciones];
                        tabla_stocks.row.add(fila_stock).draw();
                    }
                })
                .fail(function(xhr, status, error) {

                })
                .always(function() {
                    btn_agregar.prop('disabled', false);
                    btn_agregar.find('.spinner').hide();
                    btn_agregar.find('.text').show();
                });

                return false;
            });
        })();

        // Modificar un stock

        (function() {
            $(document).on('click', modificar_stock, function() {
                let btn_modificar = $(this);
                let stock_id = $(this).data('stock_id');
                let nuevo_stock = $(this).parent().prev().find('input').val();

                let data = {
                    stock_id: stock_id,
                    cantidad: nuevo_stock,
                    accion: 'modificar'
                }

                $.ajax({
                    url: "{{ route('stocks.ajax') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        btn_modificar.prop('disabled', true);
                        btn_modificar.find('.spinner').show();
                        btn_modificar.find('.text').hide();
                    }
                })
                .done(function(response) {

                })
                .fail(function(xhr, status, error) {

                })
                .always(function() {
                    btn_modificar.prop('disabled', false);
                    btn_modificar.find('.spinner').hide();
                    btn_modificar.find('.text').show();
                });
            });
        })();

        // Eliminar un stock

        (function() {
            $(document).on('click', eliminar_stock, function() {
                let stock_id    = $(this).data('stock_id');
                let fila_stock  = $(this).parents('tr');
                let tabla_id    = $(this).parents('table').attr('id');
                let confirmar   = confirm('Se va a eliminar este stock, esta acción no se puede deshacer. ¿Continuar?');

                let tabla       = $('#'+ tabla_id).DataTable();
                let data;

                if (confirmar) {
                    data = {
                        stock_id: stock_id,
                        accion: 'eliminar'
                    }

                    $.ajax({
                        url: "{{ route('stocks.ajax') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        beforeSend: function() {}
                    })
                    .done(function(response) {
                        fila_stock.addClass('remove');
                        tabla.rows('.remove').remove().draw();
                    })
                    .fail(function(xhr, status, error) {

                    })
                    .always(function() {

                    });
                }
            });
        })();
    });
</script>

<style>
    .table-responsive {
        overflow: visible;
    }

    .editar-item {
        border: none;
    }

    .quick-table {
        width: 100%;
        background: #fff;
        top: 100%;
        left: 0;
        display: none;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        z-index: 5;
    }

        .quick-table .dataTables_wrapper > .row:nth-child(1),
        .quick-table .dataTables_wrapper > .row:nth-child(3) {
            display: none;
        }

    .agregar-stock .spinner,
    .modificar-stock .spinner {
        display: none;
    }

    .eliminar-stock {
        cursor: pointer;
    }

        .eliminar-stock:hover {
            color: red;
        }
</style>

@endpush

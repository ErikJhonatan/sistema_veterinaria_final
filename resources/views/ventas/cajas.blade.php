@extends('adminlte::page')

@section('title', 'VetSys | Cuadrar Caja')

@php
$heads_ingresos_tipos = [
    'Tipo',
    'Cantidad',
    'Monto',
];
$heads_cierre_caja_periodo = [
    'Medio de pago',
    'Monto',
];

$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
    'searching' => false, // Deshabilita la búsqueda
    'paging' => false, // Deshabilita la paginación
    'info' => false,
    'dom' => 'Bfrtip', // Define los elementos presentes en la tabla. Ajusta según necesidad.
    'buttons' => [], // Vacía o quita esta línea para deshabilitar los botones
    'lengthChange' => false, 
    'order' => [],
];

@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-dollar-sign"></i> Cuadrar Caja</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-body">
        <form action="{{ route('cuadrar-caja.index') }}" method="get">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-fw fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control form-control-sm" name="fecha_desde" value="{{ $filtros['fecha_desde'] }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-fw fa-calendar"></i></span>
                                </div>
                                <input type="date" class="form-control form-control-sm" name="fecha_hasta" value="{{ $filtros['fecha_hasta'] }}" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-warehouse"></i></span>
                        </div>
                        <select class="form-control form-control-sm" name="almacen">
                            <option value="" disabled selected>Almacén</option>

                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ $filtros['almacen'] == $almacen->id ? 'selected' : '' }}>{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-warehouse"></i></span>
                        </div>
                        <select class="form-control form-control-sm" name="usuario">
                            <option value="" disabled selected>Usuarios</option>

                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $filtros['usuario'] == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mt-3 text-right">
                <div class="col-md-12">
                    <button type="submit" name="accion" value="filtrar" class="btn bg-gradient-primary btn-sm btn-accion">Filtrar</button>
                    <button type="submit" name="accion" value="borrar" class="btn bg-secondary btn-sm btn-accion">Borrar</button>
                </div>
            </div>

            @csrf
            <input type="hidden" name="filtros" value="1">
        </form>
    </div>
</div>

{{-- descargar pdf --}}
<div class="mb-2">
    <a href="{{ route('cuadrarCajaPdf.pdf', ['accion' => 'filtrar','filtros' => 1, 'fecha_desde' => $filtros['fecha_desde'], 'fecha_hasta' => $filtros['fecha_hasta'], 'almacen' => $filtros['almacen'], 'usuario' => $filtros['usuario']]) }}" class="btn btn-primary" target="_blank">Descargar PDF</a>
</div>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Ingresos por tipo de producto/servicio</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <x-adminlte-datatable id="ingresos-tipos" :heads="$heads_ingresos_tipos" head-theme="light" striped hoverable bordered compressed beautify with-buttons :config="$config">

                @foreach ($resumen_ingresos_tipo as $item)

                    <tr>
                        <td>{{ $item->tipo }}</td>
                        <td>{{ (int) $item->cantidad }}</td>
                        <td>{{ Prices::symbol() }} {{ Prices::format($item->monto) }}</td>
                    </tr>

                @endforeach

                    <tr class="text-bold">
                        <td>TOTAL</td>
                        <td>{{ (int) $totales_ingresos_tipo['cantidad'] }}</td>
                        <td>{{ Prices::symbol() }} {{ Prices::format($totales_ingresos_tipo['monto']) }}</td>
                    </tr>

            </x-adminlte-datatable>
        </div>
    </div>
</div>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Cierre de caja del período</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <x-adminlte-datatable id="cierre-caja-periodo" :heads="$heads_cierre_caja_periodo" head-theme="light" striped hoverable bordered compressed beautify with-buttons :config="$config">

                @foreach ($resumen_medios_pago as $item)

                    <tr>
                        <td>{{ $item->medio_pago_nombre }}</td>
                        <td>{{ Prices::symbol() }} {{ Prices::format($item->total_importe) }}</td>
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
        $('.eliminar-venta').on('click', function() {
            let referencia = $(this).data('referencia');

            if (confirm('Va a eliminar la venta '+ referencia +', esta acción no se puede deshacer. ¿Continuar?')) {
                return true;
            }

            return false;
        });
    });
</script>

<style>

</style>

@endpush

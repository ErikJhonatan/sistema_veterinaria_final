@extends('adminlte::page')

@section('title', 'VetSys|Cajas')

@php
$heads = [
        'Fecha',
        'ID de transacción',
        'Descripción',
        'Tipo',
        'Comprobante',
        'Movimiento',
        'Medio de Pago',
        'Importe de entrada',
        'Importe de salida',
        'Opciones'
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
    'order' => []
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-cash-register"></i> Cajas</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Cajas | Entradas / Salidas</h3>
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

        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="Third group">
                <a href="{{url('cajas/create')}}?tipo=entrada" class="btn btn-info btn-sm btn-success"><i class="fas fa-fw fa-plus"></i> Crear Entrada</a>&nbsp;&nbsp;
                <a href="{{url('cajas/create')}}?tipo=salida" class="btn btn-info btn-sm btn-danger"><i class="fas fa-fw fa-plus"></i> Crear Salida</a>
            </div>

            {{-- <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn btn-danger btn-sm">Auditoria</button>
            </div> --}}

        </div>

        <hr>

        <div class="row">
            <x-adminlte-datatable id="example" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config">
                @foreach ($cajas as $caja)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($caja->created_at)->format('Y-m-d H:i:s') }}</td>
                        <td>
                            {{ $caja->transaccion }}
                        </td>
                        <td>
                            {{ $caja->descripcion }}
                        </td>
                        <td>
                            {{ $caja->tipo->nombre }}
                        </td>
                        <td>
                            {{ $caja->comprobante ?? '—' }}
                        </td>
                        <td>
                            {{ ucwords($caja->movimiento) }}
                        </td>
                        <td>
                            {{ $caja->medio_pago->FormaDePago }}
                        </td>
                        <td>
                            {!! !is_null($caja->importe_entrada) ? ('<span class="text-success">'. Prices::symbol() .' '. number_format($caja->importe_entrada, 2, ',', '') .'</span>') : '—' !!}
                        </td>
                        <td>
                            {!! !is_null($caja->importe_salida) ? ('<span class="text-danger">'. Prices::symbol() .' '. number_format($caja->importe_salida, 2, ',', '') .'</span>') : '—' !!}
                        </td>
                        <td>
                            <form action="{{ route('cajas.destroy', $caja->id) }}" method="post">
                                <button type="submit" class="eliminar-caja" title="Eliminar {{ $caja->transaccion }}" data-transaccion="{{ $caja->transaccion }}">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>

                                @method('DELETE')
                                @csrf
                            </form>
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
        $('.eliminar-caja').on('click', function() {
            let transaccion = $(this).data('transaccion');

            if (confirm('Va a eliminar el movimiento de caja '+ transaccion +', esta acción no se puede deshacer. ¿Continuar?')) {
                return true;
            }

            return false;
        });
    });
</script>

<style>
    .eliminar-caja {
        border: none;
    }
</style>

@endpush

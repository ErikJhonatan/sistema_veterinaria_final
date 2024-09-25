@extends('adminlte::page')

@section('title', 'VetSys|Comprobantes')

@php
$heads = [
        'Fecha' ,
        'Comprobante',
        'Tipo',
        'Venta',
        'Cliente',
        'Total de venta',
        'Dinero recibido',
        'Saldo pendiente',
        'Cambio / Vuelto',
        'Pagos',
        'Opciones'
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
    'order' => [],
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-receipt"></i> Comprobantes</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Listado de Comprobantes</h3>
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

        <div class="row">
            <x-adminlte-datatable id="example" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config">

                @if (isset($comprobantes))

                    @foreach ($comprobantes as $comprobante)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($comprobante->created_at)->format('Y-m-d H:i:s') }}</td>
                            <td>
                                {{ str_pad($comprobante->serie, 3, 0, STR_PAD_LEFT) }}-{{ str_pad($comprobante->comprobante, 8, 0, STR_PAD_LEFT) }}
                            </td>
                            <td>
                                {{ strtoupper($comprobante->tipo) }}
                            </td>
                            <td>
                                {{ str_pad($comprobante->venta->id, 8, 0, STR_PAD_LEFT) }}
                            </td>
                            <td>
                                {{ $comprobante->cliente->Nombre }} {{ $comprobante->cliente->Apellido }}
                            </td>
                            <td>
                                {{ Prices::symbol() }} {{ number_format($comprobante->venta->total, 2, ',', '.') }}
                            </td>
                            <td>
                                {{ Prices::symbol() }} {{ number_format($comprobante->dinero_recibido, 2, ',', '.') }}
                            </td>
                            <td>
                                {{ Prices::symbol() }} {{ number_format($comprobante->saldo_pendiente, 2, ',', '.') }}
                            </td>
                            <td>
                                {{ Prices::symbol() }} {{ number_format($comprobante->vuelto, 2, ',', '.') }}
                            </td>
                            <td>

                                @php

                                    $aprobados = 0;
                                    $anulados = 0;

                                    foreach ($comprobante->pagos as $pago) {
                                        if ($pago->anulado === 1) {
                                            $anulados += 1;
                                        }

                                        if ($pago->anulado === 0) {
                                            $aprobados += 1;
                                        }
                                    }

                                @endphp

                                <span class="text-success" title="Aprobados">{{ $aprobados }}</span> / <span class="text-danger" title="Anulados">{{ $anulados }}</span>
                            </td>
                            <td>
                                
                                <a href="{{ route('comprobantes.edit', $comprobante->id) }}">
                                    <i class="fa fa-lg fa-fw fa-eye"></i>
                                </a>
                                <a href="{{ route('comprobantes.edit', $comprobante->id) }}">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                @endif

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
    .mascotas {
        margin: 0;
        padding: 10px;
        list-style-type: none;
        text-align: left;
    }

    .eliminar-venta {
        border: none;
    }
</style>

@endpush

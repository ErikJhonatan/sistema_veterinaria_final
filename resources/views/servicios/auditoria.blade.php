@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@php
$heads = [
        'Tipo movimiento' ,
        'Valor anterior',
        'Valor nuevo',
        'usuario',
        'Fecha creacion',
        'Fecha actualizacion',
    ];
    $config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
    'order' => [],
    ];    
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i>  Auditoria servicios</h1>
@stop
@section('content')


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Listado de movimientos</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <x-adminlte-datatable  id="DataMovimientos" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config" >
                    @foreach ($movimientos as $movimiento)
                    <tr>
                       
                        <td>{{$movimiento->tipoMovimiento->nombre}}</td>
                        <td>{{$movimiento->valor_anterior}}</td>
                        <td>{{$movimiento->valor_nuevo}}</td>
                        <td>{{$movimiento->usuario->name}}</td>
                        <td>{{$movimiento->created_at}}</td>
                        <td>{{$movimiento->updated_at}}</td>
                    </tr>
                    @endforeach
                </x-adminlte-datatable>  
            </div>
        </div>
    </div>
@stop



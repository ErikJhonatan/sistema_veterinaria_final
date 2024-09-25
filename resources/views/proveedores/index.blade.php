@extends('adminlte::page')

@section('title', 'VetSys|Proveedores')

@php
$heads = [
        'Fecha de Registro' ,
        'Proveedor' ,
        'Numero Tributario',
        'Telefono Fijo',
        'Telefono Movil',
        'Forma de Pago',
        'Email',
        'opciones'
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
    'order' => []
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-shopping-cart"></i> Proveedores</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Listado de Proveedores</h3>
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
                <a href="{{url('proveedor/create')}}" class="btn btn-info btn-sm" ">Crear nuevo proveedor</a>
            </div>
            
            {{-- <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn btn-danger btn-sm">Auditoria</button>
            </div> --}}
           
        </div>
        <hr>
        <div class="row">
            <x-adminlte-datatable  id="DataProveedor" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config">
                @foreach ($proveedores as $pro)
                <tr>
                    <td>{{\Carbon\Carbon::parse($pro->created_at)->format('Y-m-d H:i:s')}}</td>
                    <td>{{$pro->Proveedor}}</td>
                    <td>{{$pro->NumeroTributario}}</td>
                    <td>{{$pro->TelefonoFijo}}</td>
                    <td>{{$pro->TelefonoMovil}}</td>
                    <td>{{$pro->formaDePago->FormaDePago}}</td>
                    <td>{{$pro->Email}}</td>
                    <td>
                        <a href="{{url('proveedor/'.$pro->id.'/edit')}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
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
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
        
    });
</script>
@endpush
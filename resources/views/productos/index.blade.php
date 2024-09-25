@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@php
$heads = [
        'Fecha de Registro' ,
        'Producto',
        'Marca',
        'Codigo Barra',
        'Linea',
        'Categoria',
        'Costo Producto',
        'Precio Producto',
        'opciones'
    ];
    $config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
        ],
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i>  Productos</h1>
@stop
@section('content')


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Listado de Productos</h3>
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
                    <a href="{{url('producto/create')}}" class="btn btn-info btn-sm">Crear nuevo Producto</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <x-adminlte-datatable  id="DataProductos" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config" >
                    @foreach ($productos as $prod)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($prod->created_at)->format('Y-m-d H:i:s')}}</td>
                        <td>{{$prod->Producto}}</td>
                        <td>{{$prod->Marca}}</td>
                        <td>{{$prod->CodigoDeBarra}}</td>
                        <td>{{$prod->idLinea}}</td>
                        <td>{{$prod->idCategoria}}</td>
                        <td>{{$prod->PrecioReferencialCompra}}</td>
                        <td>{{$prod->PrecioVenta}}</td>
                        <td>
                            <a href="{{url('producto/'.$prod->id.'/edit')}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <a href="" class="delete btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar">
                                <i class="fa fa-lg fa-fw fa-trash"></i>

                                <form action="{{ route('producto.destroy', $prod->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </div>
    </div>

@stop

@push('js')

<script >

    $(document).ready(function() {
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });

        $('.delete').on('click', function() {
            if (confirm('Se va a eliminar el elemento seleccionado. ¿Continuar?')) {
                $(this).find('form').submit();
            }

            return false;
        });
    });
</script>
@endpush




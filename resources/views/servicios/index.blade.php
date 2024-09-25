@extends('adminlte::page')

@section('title', 'VetSys|Servicios')

@php
$heads = [
        'Fecha de Registro' ,
        'Servicio',
        'Linea',
        'Categoria',
        'SubCategoria',
        'Costo Servicio',
        'Precio Servicio',
        'opciones'
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
        ],
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-briefcase-medical"></i>  Servicios</h1>
@stop
@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Listado de Servicios</h3>
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
                <a href="{{url('servicio/create')}}" class="btn btn-info btn-sm" ">Crear nuevo servicio</a>
            </div>

            {{-- <div class="btn-group mr-2" role="group" aria-label="Third group">
                <button type="button" class="btn btn-danger btn-sm">Auditoria</button>
            </div> --}}

        </div>
        <hr>
        <div class="row">
            <x-adminlte-datatable  id="DataServicios" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config">
                @foreach ($servicios as $serv)
                <tr>
                    <td>{{\Carbon\Carbon::parse($serv->created_at)->format('Y-m-d H:i:s')}}</td>
                    <td>{{$serv->Servicio}}</td>
                    <td>{{$serv->lineas->Linea}}</td>
                    <td>{{$serv->categorias->Categoria}}</td>
                    <td>{{$serv->subCategorias->SubCategoria}}</td>
                    <td>{{$serv->CostoServicio}}</td>
                    <td>{{$serv->PrecioServicio}}</td>
                    <td>
                        <a href="{{url('servicio/'.$serv->id.'/edit')}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                        <a href="" class="delete btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar">
                            <i class="fa fa-lg fa-fw fa-trash"></i>

                            <form action="{{ route('servicio.destroy', $serv->id) }}" method="POST" style="display: none;">
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
<script>
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

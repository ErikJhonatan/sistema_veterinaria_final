@extends('adminlte::page')

@section('title', 'VetSys|Almacenes')

@php
$heads = [
    'Fecha de Registro',
    'Nombre',
    'Sede',
    'Estado',
    'Opciones'
];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-warehouse"></i> Almacenes</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Almacenes</h3>
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
                <a href="{{url('almacenes/create')}}" class="btn btn-info btn-sm btn-success"><i class="fas fa-fw fa-plus"></i> Crear Almacén</a>&nbsp;&nbsp;
            </div>
        </div>

        <hr>

        <div class="row">
            <x-adminlte-datatable id="example" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config">
                @foreach ($almacenes as $almacen)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($almacen->created_at)->format('Y-m-d H:i:s')}}</td>
                        <td>
                            {{ $almacen->nombre }}
                        </td>
                        <td>
                            {{ $almacen->tipo->nombre }}
                        </td>
                        <td>
                            {!! $almacen->estado == 1 ? '<span class="text-success">Activo</span>' : '<span class="text-danger">Inactivo</span>' !!}
                        </td>
                        <td>
                            <a href="{{ url('almacenes/'.$almacen->id.'/edit') }}" class="btn btn-xs" title="Editar {{ $almacen->nombre }}">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form action="{{ route('almacenes.destroy', $almacen->id) }}" method="post" style="display: inline-block;">
                                <button type="submit" class="eliminar-item" title="Eliminar {{ $almacen->nombre }}" data-id="{{ $almacen->id }}">
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
        $('.eliminar-item').on('click', function() {
            let id = $(this).data('id');

            if (confirm('Va a eliminar el almácen ID '+ id +', esta acción no se puede deshacer. ¿Continuar?')) {
                return true;
            }

            return false;
        });
    });
</script>

<style>
    .eliminar-item {
        border: none;
    }
</style>

@endpush

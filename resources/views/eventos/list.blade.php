@extends('adminlte::page')

@section('title', 'VetSys|Eventos')

@php
$heads = [
        'Fecha Inicio' ,
        'Cliente',
        'Mascota',
        'Evento',
        'Tipo Evento',
        'Estado',
        'Responsable',
        'opciones',
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
        ],
];
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-dog"></i>  Eventos</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Listado de Eventos</h3>
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
            <x-adminlte-datatable  id="DataEventos" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config">
                @foreach ($eventos as $eve)
                <tr>
                    <td>{{$eve->FechaInicio}}</td>
                    <td>{{$eve->getCliente->Nombre.' '.$eve->getCliente->Apellido}}</td>
                    <td>{{$eve->getMascota->Mascota}}</td>
                    <td>{{$eve->Evento}}</td>
                    <td>{{$eve->getTipoEvento->TipoEvento}}</td>
                    <td>{{$eve->getEstadoEvento->EstadoEvento}}</td>
                    <td>{{$eve->getUsuario->name}}</td>
                    <td>
                        <a href="{{url('evento')}}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                        <a href="{{ route('evento.destroy', $eve->id) }}" class="delete btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
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
                return true;
            }

            return false;
        });
    });
</script>
@endpush

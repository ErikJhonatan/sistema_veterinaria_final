@extends('adminlte::page')

@section('title', 'VetSys|Configuracion')

@php
$heads = [
        'Fecha Registro' ,
        'Fecha actualizacion',
        'Tipo de Alamcen',
        'opciones',
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
        ],
];    
@endphp

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-cogs"></i>  Configuracion</h1>
@stop

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Tipo de Almacen</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#ModalNew" title="Nuevo Tipo de Almacen" ><i class="fas fa-plus"></i>
            </button>
        </div>
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
            <x-adminlte-datatable  id="DataTipoAlmacen" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config" >
                @foreach ($tipoAlmacen as $te)
                <tr>
                    <td>{{\Carbon\Carbon::parse($te->created_at)->format('Y-m-d') }}</td>
                    <td>{{\Carbon\Carbon::parse($te->updated_at)->format('Y-m-d') }}</td>
                    <td>{{$te->TipoAlmacen}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal" data-target="#ModalEdit" title="Editar Tipo de Almacen" onclick="obtenerInfoEdi('{{$te->TipoAlmacen}}', '{{$te->id}}')"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                    </td>
                    
                </tr>
                @endforeach
            </x-adminlte-datatable>  
        </div>
        <!-- Modal -->
        <div class="modal fade " id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modificar Tipo de Almacen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('tipoAlmacen/1') }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="IdTipoAlmacen" name="IdTipoAlmacen" value="" placeholder="TipoAlmacen" readonly>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="TipoAlmacen" name="TipoAlmacen" value="" placeholder="TipoAlmacen" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal New-->
        <div class="modal fade " id="ModalNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Nuevo Tipo de Almacen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('tipoAlmacen') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="TipoAlmacen" name="TipoAlmacen" value="" placeholder="TipoAlmacen" required>
                                </div>
                            </div>
                            <div class="col-md-8"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
    function obtenerInfoEdi(datos, id) {
      
            $('#TipoAlmacen').val(datos);
            $('#IdTipoAlmacen').val(id);
        }
    $(document).ready(function() {
        $('#ModalEdit').on('shown.bs.modal', function (e) {
            $('#TipoAlmacen').focus();
        });
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    });
</script>
@endpush
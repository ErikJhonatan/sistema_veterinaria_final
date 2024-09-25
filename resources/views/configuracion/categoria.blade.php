@extends('adminlte::page')

@section('title', 'VetSys|Mascotas')

@php
$heads = [
        'Fecha Registro' ,
        'Fecha actualizacion',
        'Linea',
        'Categoria',
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
        <h3 class="card-title">Categorias</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#ModalNew" title="Nueva Categoria" ><i class="fas fa-plus"></i>
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
            <x-adminlte-datatable  id="DataFormaPago" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config" >
                @foreach ($categorias as $ca)
                <tr>
                    <td>{{$ca->created_at }}</td>
                    <td>{{$ca->updated_at}}</td>
                    <td>{{$ca->linea->Linea}}</td>
                    <td>{{$ca->Categoria}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal" data-target="#ModalEdit" title="Editar Categoria" onclick="obtenerInfoEdi('{{$ca->id}}', '{{$ca->IdLinea}}', '{{$ca->Categoria}}')"><i class="fa fa-lg fa-fw fa-pen"></i></button>
                        <!-- <button type="button" class="btn btn-xs btn-default text-danger mx-1 shadow" data-toggle="modal" data-target="#ModalEdit" title="Eliminar forma de pago" onclick="obtenerInfoDel('{{$ca->idLinea}}', '{{$ca->Categoria}}')"><i class="fa fa-lg fa-fw fa-trash"></i></button> -->
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modificar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('categoria/1') }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="IdCategoria" name="IdCategoria" value="" placeholder="IdCategoria" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-sm"  id="IdLinea" name="IdLinea" required>
                                    <option value="">* Linea...</option>
                                    @foreach ($lineas as $li)
                                    <option value="{{$li->id}}">{{$li->Linea}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-table"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="Categoria" name="Categoria" value="" placeholder="* Categoria" required>
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Nueva Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('categoria') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control form-control-sm"  id="Linea" name="Linea" required>
                                    <option value="">* Linea...</option>
                                    @foreach ($lineas as $li)
                                    <option value="{{$li->id}}">{{$li->Linea}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-table"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="Categoria" name="Categoria" value="" placeholder="* Categoria" required>
                                </div>
                            </div>
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
    function obtenerInfoEdi(id, idLinea, datos) {
            $('#Categoria').val(datos);
            $('#IdCategoria').val(id);
            console.log(idLinea);
            $("#IdLinea option[value='"+idLinea+"']").attr("selected", true);
            console.log(idLinea);
        }
    $(document).ready(function() {
        $('#ModalEdit').on('shown.bs.modal', function (e) {
            $('#Categoria').focus();
        });
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    });
</script>
@endpush
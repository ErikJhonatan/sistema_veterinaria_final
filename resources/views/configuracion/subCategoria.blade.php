@extends('adminlte::page')

@section('title', 'VetSys|Configuracion')

@php
$heads = [
        'Fecha Registro' ,
        'Fecha actualizacion',
        'Categoria',
        'Sub Categoria',
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
        <h3 class="card-title">Sub Categorias</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#ModalNew" title="Nueva Sub Categoria" ><i class="fas fa-plus"></i>
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
            <x-adminlte-datatable  id="DataSubCategoria" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config" >
                @foreach ($subCategorias as $sc)
                <tr>
                    <td>{{$sc->created_at }}</td>
                    <td>{{$sc->updated_at}}</td>
                    <td>{{$sc->idCategoria}}</td>
                    <td>{{$sc->SubCategoria}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal" data-target="#ModalEdit" 
                            title="Editar Categoria" onclick="obtenerInfoEdi('{{$sc->id}}', '{{$sc->idCategoria}}', '{{$sc->SubCategoria}}')">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
                    </td>
                    
                </tr>
                @endforeach
            </x-adminlte-datatable>  
        </div>
        <!-- Modal Edit -->
        <div class="modal fade " id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modificar Sub Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('subCategoria/1') }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="IdSubCategoria" name="IdSubCategoria" value="" placeholder="IdSubCategoria" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-sm"  id="IdCategoria" name="IdCategoria" required>
                                    <option value="">* Categoria...</option>
                                    @foreach ($categorias as $ca)
                                    <option value="{{$ca->id}}">{{$ca->Categoria}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-border-all"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="SubCategoria" name="SubCategoria" value="" placeholder="* Sub Categoria" required>
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Nueva Sub Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('subCategoria') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control form-control-sm"  id="Categoria" name="Categoria" required>
                                    <option value="">* Categoria...</option>
                                    @foreach ($categorias as $ca)
                                    <option value="{{$ca->id}}">{{$ca->Categoria}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-border-all"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="SubCategoria" name="SubCategoria" value="" placeholder="* SubCategoria" required>
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
    function obtenerInfoEdi(id, idCategoria, datos) {
            $('#SubCategoria').val(datos);
            $('#IdSubCategoria').val(id);
            $("#IdCategoria option[value='"+idCategoria+"']").attr("selected", true);
         
        }
    $(document).ready(function() {
        $('#ModalEdit').on('shown.bs.modal', function (e) {
            $('#SubCategoria').focus();
        });
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    });
</script>
@endpush
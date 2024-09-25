@extends('adminlte::page')

@section('title', 'VetSys|Configuracion')

@php
$heads = [
        'Fecha Registro' ,
        'Fecha actualizacion',
        'Especie',
        'Raza',
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
        <h3 class="card-title">Raza</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#ModalNew" title="Nueva Raza" ><i class="fas fa-plus"></i>
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
            <x-adminlte-datatable  id="DataRaza" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify  with-buttons :config="$config" >
                @foreach ($razas as $ra)
                <tr>
                    <td>{{$ra->created_at }}</td>
                    <td>{{$ra->updated_at}}</td>
                    <td>{{$ra->especie->Especie}}</td>
                    <td>{{$ra->Raza}}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" data-toggle="modal" data-target="#ModalEdit" 
                            title="Editar Raza" onclick="obtenerInfoEdi('{{$ra->id}}', '{{$ra->idEspecie}}', '{{$ra->Raza}}')"><i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modificar Raza</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('raza/1') }}" method="post">
                    @method("PUT")
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-sm" id="IdRaza" name="IdRaza" value="" placeholder="IdRaza" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control form-control-sm"  id="IdEspecie" name="IdEspecie" required>
                                    <option value="">* Especie...</option>
                                    @foreach ($especies as $es)
                                    <option value="{{$es->id}}">{{$es->Especie}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-paw"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="Raza" name="Raza" value="" placeholder="* Raza" required>
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
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Nueva Raza</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('raza') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control form-control-sm"  id="Especie" name="Especie" required>
                                    <option value="">* Especies...</option>
                                    @foreach ($especies as $li)
                                    <option value="{{$li->id}}">{{$li->Especie}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-paw"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="Raza" name="Raza" value="" placeholder="* Raza" required>
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
            $('#Raza').val(datos);
            $('#IdRaza').val(id);
            $("#IdEspecie option[value='"+idLinea+"']").attr("selected", true);
        }
    $(document).ready(function() {
        $('#ModalEdit').on('shown.bs.modal', function (e) {
            $('#Raza').focus();
        });
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#success-alert").slideUp(500);
        });
    });
</script>
@endpush
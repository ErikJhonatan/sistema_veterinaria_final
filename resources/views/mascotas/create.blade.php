@extends('adminlte::page')

@section('title', 'VetSys|Mascotas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-dog"></i>Mascotas</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Registrar Mascota</h3>
    </div>
    <form action="{{ url('mascota') }}" method="post">
        @csrf
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
            </div>
        @endif
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Propietario" name="Propietario" required>
                        <option value="">* Propietario...</option>
                        @foreach ($clientes as $clie)
                        <option value="{{$clie->id}}">{{$clie->Nombre.' '.$clie->Apellido.' | '.$clie->DocumentoIdentidad}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-paw"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NombreMascota" name="NombreMascota" value="{{old('NombreMascota')}}"placeholder="* Nombre de mascota" required>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Especie" name="Especie" required>
                        <option value="">* Especie ...</option>
                        @foreach ($especies as $espe)
                        <option value="{{$espe->id}}">{{$espe->Especie}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Raza" name="Raza" required>
                        <option value="">* Raza ...</option>
                        {{-- @foreach ($razas as $raza)
                        <option value="{{$raza->id}}">{{$raza->Raza}}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Sexo" name="Sexo">
                        <option value="">Sexo ...</option>
                        <option value="1">Macho</option>
                        <option value="2">Hembra</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-birthday-cake"></i></i></span>
                    </div>
                    <input type="text" id="FechaNacimiento" name="FechaNacimiento" class="form-control form-control-sm"  data-inputmask="'alias': 'date'" value="{{old('FechaNacimiento')}}" placeholder="Fecha de nacimiento" required > 
                </div>               
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NumeroHistoria" name="NumeroHistoria" value="{{old('NumeroHistoria')}}" placeholder="Numero de historia">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NumeroMicrochip" name="NumeroMicrochip" value="{{old('NumeroMicrochip')}}" placeholder="Numero de microchip">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Esterilizado" name="Esterilizado">
                        <option value="">Ha sido esterelizado ...</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Asegurado" name="Asegurado">
                        <option value="">¿Está asegurado? (En caso de contar con algun plan de seguro de salud)...</option>
                        <option value="1">Si</option>
                        <option value="2">No</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text-tarea" class="form-control form-control-sm" id="Notas" name="Notas" value="{{old('Notas')}}" placeholder="Notas">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <h5 class="m-0 text-dark"><i class="fas fa-bath"></i> Opciones para órdenes de grooming</h5>
            </div>
        </div>
        <div class="row">              
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Grooming" name="Grooming">
                        <option value="">Crear un evento de grooming automáticamente...</option>
                        <option value="1">No</option>
                        <option value="2">Si</option>
                    </select>
                </div> 
                <div class="form-group">
                    <select class="form-control form-control-sm" id="DiaPreferido" name="DiaPreferido">
                        <option value="">Día preferido de la semana...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Frecuencia" name="Frecuencia">
                        <option value="">Frecuencia en días (intervalo de tiempo entre cada servicio)...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div> 
            </div>
        </div>
        <!-- <div class="input-group mb-3">
            <input type="text-tare" class="form-control form-control-sm" id="Observaciones" name="Observaciones" value="{{old('Observaciones')}}" placeholder="Observaciones">
        </div> -->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid gap-3 d-md-block mb-3">
                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Crear mascota</button>         
                    <button type="reset" class="btn bg-gradient-warning btn-sm"><i class="fas fa-window-close"></i>  Cancelar</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" d-md-flex justify-content-md-end">
                    <a href="{{url('mascota')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-undo-alt"></i>  Regresar </a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>  

@stop

@push('js')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
    $(document).ready(function() {
        $(":input").inputmask();
        $('#Propietario').select2();

        $("#Especie").change(function(){
            $("#Raza").empty();
            $.ajax({  
                type: "GET",  
                url: "/getRazas/"+$(this).val(),    
                dataType: "json", 
                success: function (data) { 
                    var option = "<option value=''>* Raza...</option>";
                    $.each(data, function(i,item){
                        option = option+"<option value='" + item.id + "'>"+ item.Raza+ "</option>";
                    });
                    $("#Raza").append(option);
                }, //End of AJAX Success function  
             });        
        });

    });
</script>
@endpush
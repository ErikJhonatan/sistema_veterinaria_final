@extends('adminlte::page')

@section('title', 'VetSys|Mascotas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-dog"></i>Mascotas</h1>
@stop

@section('content')
<div class="flex flex-row">
    <div class="card" style="min-width: 270px;">
        <div class="card-header">
        <img src="/vendor/adminlte/dist/img/mascota.png" alt="Dog Avatar" class="img-circle" style="width: 100px; height: 100px;">
            <h2>{{ $mascota->NombreMascota }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $mascota->Mascota }}</p>
            <p><strong>Identificador:</strong> 00-{{ $mascota->id }}</p>
            <p><strong>Propietario:</strong> {{ $mascota->cliente->Nombre }}</p>
            <p><strong>Especie:</strong> {{ $mascota->especie->Especie }}</p>
            <p><strong>Raza:</strong> {{ $mascota->raza->Raza }}</p>
            <p><strong>Número de Historia:</strong> {{ $mascota->NumeroHistoria }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $mascota->FechaNacimiento }}</p>
            <p><strong>Sexo:</strong> {{ $mascota->Sexo == '1' ? 'M' : 'F'  }}</p>
            <p><strong>Esterilizado:</strong> {{ $mascota->Esterilizado ? 'Si' : 'No' }}</p>
            <p><strong>Asegurado:</strong> {{ $mascota->Asegurado ? 'Si' : 'No' }}</p>
        </div>
    </div>
    <div class="card card-success w-100"
    >
        <div class="card-header flex flex-row flex-wrap items-center gap-4">
            <a 
            href="{{url('mascota/'.$mascota->id.'/edit')}}"  
            class="flex flex-row items-center gap-1 bg-yellow-600 p-2 rounded"
            >
                <i class="fas fa-edit"></i>
                <div>
                    Modificar mascota
                </div>
            </a>
        
            <a  
            href="{{url('mascota/'.$mascota->id.'/historial-clinico')}}" 
            class="flex flex-row items-center gap-1  p-2 rounded bg-yellow-400"
            >
                <i class="fas fa-notes-medical"></i> 
                <div>
                    Historial Clinico
                </div>
            </a>
        
        
            <a  
            href="{{url('mascota/'.$mascota->id.'/galeria')}}" 
            class="flex flex-row items-center gap-1 bg-yellow-400 p-2 rounded"
            >
                <i class="fas fa-images"></i>
                <div>
                    Galeria
                </div>
            </a>
        
        
            <a  
            href="{{url('mascota/'.$mascota->id.'/historial-compra')}}" 
            class="flex flex-row items-center gap-1  bg-yellow-400 p-2 rounded">
                <i class="fas fa-shopping-cart"></i>
                <div>
                    Historial de compra
                </div>
            </a>
        </div>
        <form action="{{ url('mascota/'.$mascota->id) }}" method="post">
            @method("PUT")
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
                            <option value="{{$clie->id}}" @if ($clie->id == $mascota->idCliente){{'selected'}}@endif>{{$clie->Nombre.' '.$clie->Apellido.' | '.$clie->DocumentoIdentidad}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-paw"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="NombreMascota" name="NombreMascota" value="{{$mascota->Mascota}}"placeholder="* Nombre de mascota" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="Especie" name="Especie" required>
                            <option value="">* Especie ...</option>
                            @foreach ($especies as $espe)
                            <option value="{{$espe->id}}" @if ($espe->id == $mascota->idEspecie){{'selected'}}@endif >{{$espe->Especie}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="Raza" name="Raza" required>
                            <option value="">* Raza ...</option>
                            <option value="{{$mascota->raza->id}}" @if ($mascota->raza->id == $mascota->idRaza){{'selected'}}@endif >{{$mascota->raza->Raza}}</option>
                            {{-- @foreach ($razas as $raza)
                            <option value="{{$raza->id}}">{{$raza->Raza}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="Sexo" name="Sexo">
                            <option value="">Sexo ...</option>
                            <option value="1" @if ($mascota->Sexo == 1){{'selected'}}@endif>Macho</option>
                            <option value="2" @if ($mascota->Sexo == 2){{'selected'}}@endif>Hembra</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></i></span>
                        </div>
                        <input type="text" id="FechaNacimiento" name="FechaNacimiento" class="form-control form-control-sm"  data-inputmask="'alias': 'date'" value="{{\Carbon\Carbon::parse($mascota->FechaNacimiento)->format('d/m/Y') }}" placeholder="Fecha de nacimiento" required> 
                    </div>               
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="NumeroHistoria" name="NumeroHistoria" value="{{$mascota->NumeroHistoria}}" placeholder="Numero de historia">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="NumeroMicrochip" name="NumeroMicrochip" value="{{$mascota->Microchip}}" placeholder="Numero de microchip">
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="Esterilizado" name="Esterilizado">
                            <option value="">Ha sido esterelizado ...</option>
                            <option value="1" @if ($mascota->Esterilizado == 1){{'selected'}}@endif >Si</option>
                            <option value="2" @if ($mascota->Esterilizado == 2){{'selected'}}@endif >No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm" id="Asegurado" name="Asegurado">
                            <option value="">¿Está asegurado? (En caso de contar con algun plan de seguro de salud)...</option>
                            <option value="1" @if ($mascota->Asegurado == 1){{'selected'}}@endif  >Si</option>
                            <option value="2" @if ($mascota->Asegurado == 2){{'selected'}}@endif>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <input type="text-tarea" class="form-control form-control-sm" id="Notas" name="Notas" value="{{$mascota->Notas}}" placeholder="Notas">
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
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-grid gap-3 d-md-block mb-3">
                        <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Actualizar mascota</button>         
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

</div>

@stop

@push('css')
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
@endpush

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
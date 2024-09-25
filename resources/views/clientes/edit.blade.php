@extends('adminlte::page')

@section('title', 'VetSys|Clientes')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-users"></i> Clientes</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Modificar Cliente </h3>
    </div>
    <form action="{{ url('cliente/'.$cliente->id) }}" method="post">
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
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Nombre" name="Nombre" value="{{$cliente->Nombre}}" placeholder="Nombre" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Apellido" name="Apellido" value="{{$cliente->Apellido}}" placeholder="Apellido" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="DocumentoIdentidad" name="DocumentoIdentidad" value="{{$cliente->DocumentoIdentidad}}" placeholder="Documento de identidad" maxlength="8" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="FechaNacimiento" name="FechaNacimiento" data-inputmask="'alias': 'date'" value="{{ $cliente->FechaNacimiento ?  \Carbon\Carbon::parse($cliente->FechaNacimiento)->format('d/m/Y') : null }}" placeholder="Fecha de nacimiento" >
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control form-control-sm" id="Email" name="Email" value="{{$cliente->Email}}" placeholder="Correo electronico">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="tel" class="form-control form-control-sm" id="TelefonoFijo" name="TelefonoFijo" value="{{$cliente->TelefonoFijo}}" placeholder="Telefono de casa">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="tel" class="form-control form-control-sm" id="TelefonoTrabajo" name="TelefonoTrabajo" value="{{$cliente->TelefonoTrabajo}}" placeholder="Telefono de trabajo">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                    </div>
                    <input type="tel" class="form-control form-control-sm" id="TelefonoMovil" name="TelefonoMovil" value="{{$cliente->TelefonoMovil}}" placeholder="Telefono movil">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Facebook" name="Facebook" value="{{$cliente->Facebook}}" placeholder="Facebook">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Instagram" name="Instagram" value="{{$cliente->Instagram}}" placeholder="Instagram">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Departamento" name="Departamento" required>
                        <option value="">Departamento...</option>
                        @foreach ($departamentos as $depto)
                        <option value="{{$depto->id}}" @if ($depto->id == $cliente->idDepartamento){{'selected'}}@endif>{{$depto->Departamento}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Provincia" name="Provincia" required>
                        <option value="">Provincia...</option>
                        @foreach ($provincias as $prov)
                        <option value="{{$prov->id}}" @if ($prov->id == $cliente->idProvincia){{'selected'}}@endif >{{$prov->Provincia}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Distrito" name="Distrito" required>
                        <option value="">Distrito...</option>
                        @foreach ($distritos as $dist)
                        <option value="{{$dist->id}}" @if ($dist->id == $cliente->idDistrito){{'selected'}}@endif >{{$dist->Distrito}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group">
                    <select class="form-control form-control-sm" id="ZonaResidencia" name="ZonaResidencia">
                        <option value="">Zona de Residencia...</option>
                        <option value="1">A</option>
                        <option value="2">B</option> 
                    </select>
                </div> --}}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Direccion" name="Direccion" value="{{$cliente->Direccion}}" placeholder="Direccion" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-thumbtack"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="ReferenciaDireccion" name="ReferenciaDireccion" value="{{$cliente->ReferenciaDireccion}}" placeholder="Referencia de direccion">
                </div>
    
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NombreEmpresa" name="NombreEmpresa" value="{{$cliente->NombreEmpresa}}" placeholder="Nombre de empresa">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="RegistroTributario" name="RegistroTributario" value="{{$cliente->RegistroTributario}}" placeholder="Número de registro tributario">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="DireccionEmpresa" name="DireccionEmpresa" value="{{$cliente->DireccionEmpresa}}" placeholder="Dirección de empresa">
                </div>
                <div class="form-group form-control-sm">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="ClienteReferido" name="ClienteReferido" @if ($cliente->ClienteReferido == true ){{'checked'}}@endif>
                      <label class="custom-control-label" for="ClienteReferido">Cliente referido de otra clínica (externo)</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text-tare" class="form-control form-control-sm" id="Observaciones" name="Observaciones" value="{{$cliente->Observaciones}}" placeholder="Observaciones">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid gap-3 d-md-block mb-3">
                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Actualizar Cliente</button>         
                    <button type="reset" class="btn bg-gradient-warning btn-sm"><i class="fas fa-window-close"></i>  Cancelar</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" d-md-flex justify-content-md-end">
                    <a href="{{url('cliente')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-undo-alt"></i>  Regresar </a>
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
        $('#DocumentoIdentidad, #TelefonoFijo, #TelefonoTrabajo, #TelefonoMovil').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });

        $("#Departamento").change(function(){
            $("#Provincia").empty();
            $("#Distrito").empty();
            $.ajax({  
                type: "GET",  
                url: "/getProvincias/"+$(this).val(),    
                dataType: "json", 
                success: function (data) { 
                    var option = "<option value=''>Provincia...</option>";
                    $.each(data, function(i,item){
                        option = option+"<option value='" + item.id + "'>"+ item.Provincia+ "</option>";
                    });
                    $("#Provincia").append(option);
                }, //End of AJAX Success function  
             });
            $("#Distrito").append("<option value=''>Distrito...</option>");         
        });

        $("#Provincia").change(function(){
            $("#Distrito").empty();
            $.ajax({  
                type: "GET",  
                url: "/getDistritos/"+$(this).val(),    
                dataType: "json", 
                success: function (data) { 
                    var option = "<option value=''>Distrito...</option>";
                    $.each(data, function(i,item){
                        option = option+"<option value='"+item.id+"'>"+ item.Distrito+ "</option>";
                    });
                    $("#Distrito").append(option);
                }, //End of AJAX Success function  
             });         
        });
    });
</script>
@endpush
@extends('adminlte::page')

@section('title', 'VetSys|Proveedores')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-shopping-cart"></i> Proveedores</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Registrar Proveedor</h3>
    </div>
    <form action="{{ url('proveedor') }}" method="post">
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
                        <span class="input-group-text"><i class="fas fa-address-book"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NombrePrveedor" name="NombrePrveedor" value="{{old('NombrePrveedor')}}" placeholder="* Nombre del proveedor" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="IdentificadorTributario" name="IdentificadorTributario" value="{{old('IdentificadorTributario')}}" placeholder="* Identificador Tributario (RUC, NIT)" maxlength="20" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control form-control-sm" id="Email" name="Email" value="{{old('Email')}}" placeholder="Correo Electrónico">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="CuentaBancaria" name="CuentaBancaria" value="{{old('CuentaBancaria')}}" placeholder="Cuenta Bancaria" maxlength="20">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Direccion" name="Direccion" value="{{old('Direccion')}}" placeholder="Dirección">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="TelefonoFijo" name="TelefonoFijo" value="{{old('TelefonoFijo')}}" placeholder="* Teléfono Fijo" maxlength="9" required> 
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="TelefonoMovil" name="TelefonoMovil" value="{{old('TelefonoMovil')}}" placeholder="Teléfono Movil" maxlength="9" >
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="SitioWeb" name="SitioWeb" value="{{old('SitioWeb')}}" placeholder="Sitio Web">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="FormaPago" name="FormaPago" required>
                        <option value="">Forma de Pago...</option>
                        @foreach ($formaPagos as $formapago)
                        <option value="{{$formapago->id}}">{{$formapago->FormaDePago}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="PersonaContacto" name="PersonaContacto" value="{{old('PersonaContacto')}}" placeholder="Persona de Contacto">
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text-tare" class="form-control form-control-sm" id="Observaciones" name="Observaciones" value="{{old('Observaciones')}}" placeholder="Observaciones">
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid gap-3 d-md-block mb-3">
                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Crear Proveedor</button>         
                    <button type="reset" class="btn bg-gradient-warning btn-sm"><i class="fas fa-window-close"></i>  Cancelar</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" d-md-flex justify-content-md-end">
                    <a href="{{url('proveedor')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-undo-alt"></i>  Regresar </a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>  

@stop

@push('js')
<script>
    $(document).ready(function() {
        $('#CuentaBancaria, #TelefonoFijo, #TelefonoMovil','#IdentificadorTributario').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });
    });
</script>
@endpush
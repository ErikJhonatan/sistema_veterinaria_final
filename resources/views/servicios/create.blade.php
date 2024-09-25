@extends('adminlte::page')

@section('title', 'VetSys|Servicios')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-briefcase-medical"></i>  Servicios</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Registrar Servicios</h3>
    </div>
    <form action="{{ url('servicio') }}" method="post">
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
                        <span class="input-group-text"><i class="fas fa-briefcase-medical"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NombreServicio" name="NombreServicio" value="{{old('NombreServicio')}}" placeholder="* Nombre del servicio" required>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Linea" name="Linea" required>
                        <option value="">* Linea...</option>
                        @foreach ($lineas as $lineas)
                        <option value="{{$lineas->id}}">{{$lineas->Linea}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="CostoServicio" name="CostoServicio" value="{{old('CostoServicio')}}" placeholder="* Costo del servicio (incluido impuestos)" onkeypress="return filterFloat(event,this);" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Categoria" name="Categoria" required>
                        <option value="">* Categoria...</option>
                        {{-- @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id}}">{{$categoria->Categoria}}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="SubCategoria" name="SubCategoria">
                        <option value="">SubCategoria...</option>
                        {{-- @foreach ($subCategorias as $SubCategoria)
                        <option value="{{$SubCategoria->id}}">{{$SubCategoria->SubCategoria}}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="PrecioServicio" name="PrecioServicio" value="{{old('PrecioServicio')}}" placeholder="* Precio del servicio (incluido impuestos)" onkeypress="return filterFloat(event,this);" required >
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="ExoneradoImpuestos" name="ExoneradoImpuestos">
                      <label class="custom-control-label" for="ExoneradoImpuestos">¿Exonerado de impuestos?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid gap-3 d-md-block mb-3">
                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Crear Servicio</button>         
                    <button type="reset" class="btn bg-gradient-warning btn-sm"><i class="fas fa-window-close"></i>  Cancelar</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" d-md-flex justify-content-md-end">
                    <a href="{{url('servicio')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-undo-alt"></i>  Regresar </a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>  

@stop

@push('js')
<script>
    function filterFloat(evt,input){
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;   
        var chark = String.fromCharCode(key);
        var tempValue = input.value+chark;
        var isNumber = (key >= 48 && key <= 57);
        var isSpecial = (key == 8 || key == 13 || key == 0 ||  key == 46);
        if(isNumber || isSpecial){
            return filter(tempValue);
        }        
        return false;    
    }
    function filter(__val__){
        var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        return (preg.test(__val__) === true);
    }
    
    $(document).ready(function() {
        $("#Linea").change(function(){
            $("#Categoria").empty();
            $("#SubCategoria").empty();
            $.ajax({  
                type: "GET",  
                url: "/getCategorias/"+$(this).val(),    
                dataType: "json", 
                success: function (data) { 
                    var option = "<option value=''>* Categoria...</option>";
                    $.each(data, function(i,item){
                        option = option+"<option value='" + item.id + "'>"+ item.Categoria+ "</option>";
                    });
                    $("#Categoria").append(option);
                }, 
             });
            $("#SubCategoria").append("<option value=''>SubCategoria...</option>");         
        });

        $("#Categoria").change(function(){
            $("#SubCategoria").empty();
            $.ajax({  
                type: "GET",  
                url: "/getSubCategorias/"+$(this).val(),    
                dataType: "json", 
                success: function (data) { 
                    var option = "<option value=''>SubCategoria...</option>";
                    $.each(data, function(i,item){
                        option = option+"<option value='"+item.id+"'>"+ item.SubCategoria+ "</option>";
                    });
                    $("#SubCategoria").append(option);
                }, 
             });         
        });

        // $('#CostoServicio, #PrecioServicio').on('input', function () { 
        //     //this.value = this.value.replace(/^\d+(\.\d{0,2})?$/,'');
        //     this.value = this.value.replace(\^[0-9]$ {0,2}\,'');
            
        //     console.log(this.value);
            
        // });

  
    });
</script>
@endpush
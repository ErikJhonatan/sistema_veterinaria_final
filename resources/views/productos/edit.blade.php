@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i>  Productos</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header flex flex-row items-center gap-4">
        <a href="{{url('producto/'.$producto->id.'/edit')}}"  class="bg-yellow-600 p-2 rounded">
                   Modificar Producto
        </a>
        <a  href="{{url('producto/'.$producto->id.'/galeria')}}" class="bg-yellow-400 p-2 rounded">
            Galeria
        </a>
    </div>
    <form action="{{ url('producto/'.$producto->id)}}" method="post">
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
                        <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="NombreProducto" name="NombreProducto" value="{{$producto->Producto}}" placeholder="* Nombre del producto" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-briefcase-medical"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Marca" name="Marca" value="{{$producto->Marca}}" placeholder="Marca">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Contenido" name="Contenido" value="{{$producto->Contenido}}" placeholder="Contenido">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Linea" name="Linea" required>
                        <option value="">* Linea...</option>
                        @foreach ($lineas as $lineas)
                        <option value="{{$lineas->id}}" @if ($lineas->id == $producto->idLinea){{'selected'}}@endif >{{$lineas->Linea}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="CodigoBarra" name="CodigoBarra" value="{{$producto->CodigoDeBarra}}" placeholder="codigo de barra">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-arrow-up"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="StockMaximo" name="StockMaximo" value="{{$producto->StockMaximo}}" placeholder="* Stock Maximo" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="PrecioCompra" name="PrecioCompra" value="{{$producto->PrecioReferencialCompra}}" placeholder="Precio Referencial de Compra (Incluido Impuestos)" onkeypress="return filterFloat(event,this);">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="PrecioVenta" name="PrecioVenta" value="{{$producto->PrecioVenta}}" placeholder="Precio de Venta (Incluido Impuestos)" onkeypress="return filterFloat(event,this);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Proveedor" name="Proveedor" required>
                    <option value="">* Proveedor...</option>
                        @foreach ($proveedores as $prove)
                        <option value="{{$prove->id}}" @if ($prove->id == $producto->idProveedor){{'selected'}}@endif> {{$prove->Proveedor.' '.' | '.$prove->NumeroTributario}}</option>
                        @endforeach
                    </select>
                </div>                
                
                <div class="form-group">
                    <select class="form-control form-control-sm" id="UnidadMedida" name="UnidadMedida" required>
                        <option value="">* Unidad de medida...</option>
                        @foreach ($unidadMedidas as $uniMed)
                        <option value="{{$uniMed->id}}" @if ($uniMed->id == $producto->idUnidadMedida){{'selected'}}@endif>{{$uniMed->UnidadMedida}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm"  id="Presentacion" name="Presentacion" required>
                        <option value="">* Presentacion...</option>
                        @foreach ($presentaciones as $pre)
                        <option value="{{$pre->id}}" @if ($pre->id == $producto->idPresentacion){{'selected'}}@endif>{{$pre->Presentacion}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Categoria" name="Categoria" required>
                        <option value="">* Categoria...</option>
                        @foreach ($categorias as $categoria)
                        <option value="{{$categoria->id}}" @if ($categoria->id == $producto->idCategoria){{'selected'}}@endif>{{$categoria->Categoria}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm" id="SubCategoria" name="SubCategoria">
                        <option value="">SubCategoria...</option>
                        @foreach ($subCategoria as $SubCategorias)
                        <option value="{{$SubCategorias->id}}" @if ($SubCategorias->id == $producto->idSubCategoria){{'selected'}}@endif> {{$SubCategorias->SubCategoria}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-arrow-down"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="StockMinimo" name="StockMinimo" value="{{$producto->StockMinimo}}" placeholder="* Stock Minimo" required>
                </div>               
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="ExoneradoCompra" name="ExoneradoCompra" @if($producto->ExoneradoCompra == true ){{'checked'}}@endif>
                        <label class="custom-control-label" for="ExoneradoCompra">¿Exonerado de impuestos al comprar?</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="ExoneradoVenta" name="ExoneradoVenta" @if ($producto->ExoneradoVenta== true ){{'checked'}}@endif>
                        <label class="custom-control-label" for="ExoneradoVenta">¿Exonerado de impuestos al vender?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <div class="d-grid gap-3 d-md-block mb-3">
                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Actualizar Producto</button>         
                    <button type="reset" class="btn bg-gradient-warning btn-sm"><i class="fas fa-window-close"></i>  Cancelar</button>
                </div>
            </div>
            <div class="col-md-6">
                <div class=" d-md-flex justify-content-md-end">
                    <a href="{{url('producto')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-undo-alt"></i>  Regresar </a>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>  

@stop

@push('css')
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
@endpush

@push('js')
<!-- <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script> -->
<script>
    $(document).ready(function() {
        
        $('#StockMinimo, #StockMaximo, #CodigoBarra').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
        });

        $('#Proveedor').select2();


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
    });

</script>
@endpush
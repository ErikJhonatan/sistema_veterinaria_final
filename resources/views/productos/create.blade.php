@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i>  Productos</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Registrar Producto</h3>
    </div>
    <form action="{{ url('producto') }}" method="post">
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
                    <input type="text" class="form-control form-control-sm" id="NombreProducto" name="NombreProducto" value="{{old('NombreProducto')}}" placeholder="* Nombre del producto" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-briefcase-medical"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Marca" name="Marca" value="{{old('Marca')}}" placeholder="Marca">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="Contenido" name="Contenido" value="{{old('Contenido')}}" placeholder="Contenido">
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
                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="CodigoBarra" name="CodigoBarra" value="{{old('CodigoBarra')}}" placeholder="codigo de barra">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-arrow-up"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="StockMaximo" name="StockMaximo" value="{{old('StockMaximo')}}" placeholder="* Stock Maximo" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="PrecioCompra" name="PrecioCompra" value="{{old('PrecioCompra')}}" placeholder="Precio Referencial de Compra (Incluido Impuestos)" onkeypress="return filterFloat(event,this);">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                    </div>
                    <input type="number" step="0.01" min="0" class="form-control form-control-sm" id="PrecioVenta" name="PrecioVenta" value="{{old('PrecioVenta')}}" placeholder="Precio de Venta (Incluido Impuestos)" onkeypress="return filterFloat(event,this);">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <select class="form-control form-control-sm" id="Proveedor" name="Proveedor" required>
                        <option value="">* Proveedor...</option>
                        @foreach ($proveedores as $prove)
                        <option value="{{$prove->id}}">{{$prove->Proveedor.' '.' | '.$prove->NumeroTributario}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <select class="form-control form-control-sm" id="UnidadMedida" name="UnidadMedida" required>
                        <option value="">* Unidad de medida...</option>
                        @foreach ($unidadMedidas as $uniMed)
                        <option value="{{$uniMed->id}}">{{$uniMed->UnidadMedida}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control form-control-sm"  id="Presentacion" name="Presentacion" required>
                        <option value="">* Presentacion...</option>
                        @foreach ($presentaciones as $pre)
                        <option value="{{$pre->id}}">{{$pre->Presentacion}}</option>
                        @endforeach
                    </select>
                </div>
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
                        <span class="input-group-text"><i class="fas fa-arrow-down"></i></span>
                    </div>
                    <input type="text" class="form-control form-control-sm" id="StockMinimo" name="StockMinimo" value="{{old('StockMinimo')}}" placeholder="* Stock Minimo" required>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="ExoneradoCompra" name="ExoneradoCompra">
                        <label class="custom-control-label" for="ExoneradoCompra">¿Exonerado de impuestos al comprar?</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="ExoneradoVenta" name="ExoneradoVenta">
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
                    <button type="submit" class="btn bg-gradient-primary btn-sm"><i class="fas fa-save"></i>  Crear Producto</button>
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

@push('js')
<!-- <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script> -->
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

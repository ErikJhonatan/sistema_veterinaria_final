@extends('adminlte::page')
@section('title', 'VetSys|Cajas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-warehouse"></i> Almacenes</h1>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Modificar almacén</h3>
    </div>
    <form action="{{ url('almacenes/'. $almacen->id) }}" method="post">
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
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-sticky-note"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="nombre" value="{{ old('nombre') ?? $almacen->nombre }}" placeholder="* Nombre" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-warehouse"></i></span>
                        </div>
                        <select class="form-control form-control-sm" name="sede_id" required>
                            <option value="" disabled selected>Seleccionar tipo...</option>

                            @foreach ($tipos_almacenes as $tipo_almacen)
                                <option value="{{ $tipo_almacen->id }}" {{ $tipo_almacen->id == $almacen->sede_id ? 'selected' : '' }}>{{ $tipo_almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-grid gap-3 d-md-block">
                        <button type="submit" class="btn bg-gradient-primary btn-sm btn-accion"><i class="fas fa-fw fa-save"></i> Actualizar</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class=" d-md-flex justify-content-md-end">
                        <a href="{{url('almacenes')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-fw fa-undo-alt"></i> Regresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="post"></div>
    </form>
</div>

@stop

@push('js')
<script>
    $(document).ready(function() {
    });
</script>

<style>

</style>
@endpush

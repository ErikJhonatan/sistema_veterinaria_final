@extends('adminlte::page')
@section('title', 'VetSys|Cajas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-fw fa-dolly-flatbed"></i> Cajas</h1>
@stop

@php
$heads = [
        'Item',
        'Valor Unitario',
        'Cantidad',
        'Subtotal',
        'Impuestos',
        'Total',
        'Mascota',
        'Opciones'
    ];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
];
@endphp

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Crear {{ ucwords($tipo) }}</h3>
    </div>
    <form action="{{ url('cajas') }}" method="post">
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
                            <span class="input-group-text"><i class="fas fa-fw fa-calendar"></i></span>
                        </div>
                        <input type="date" class="form-control form-control-sm" name="fecha" value="{{old('fecha')}}" placeholder="" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-sticky-note"></i></span>
                        </div>
                        <input type="text" class="form-control form-control-sm" name="descripcion" value="{{old('descripcion')}}" placeholder="* Descripción" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-dollar-sign"></i></span>
                        </div>
                        <input type="number" class="form-control form-control-sm" name="monto" value="{{old('monto')}}" placeholder="* Monto" min="0" step="0.01" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-credit-card"></i></span>
                        </div>
                        <select class="form-control form-control-sm" name="medio_pago_id" required>
                            <option value="" disabled selected>Seleccionar...</option>

                            @foreach ($medios_pago as $medio_pago)
                                <option value="{{ $medio_pago->id }}">{{ $medio_pago->FormaDePago }}</option>
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
                        <button type="submit" class="btn bg-gradient-primary btn-sm btn-accion"><i class="fas fa-fw fa-save"></i> Crear {{ ucwords($tipo) }}</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class=" d-md-flex justify-content-md-end">
                        <a href="{{url('cajas')}}" class="btn bg-gradient-secondary btn-sm" ><i class="fas fa-fw fa-undo-alt"></i> Regresar</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="post"></div>

        <input type="hidden" name="movimiento" value="{{ $tipo }}">
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

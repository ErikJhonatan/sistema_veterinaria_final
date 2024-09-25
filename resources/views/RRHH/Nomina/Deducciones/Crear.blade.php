@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Empleados </h1>

@stop
@section('content')
<div class="card-body">
    <form action="{{ route('CrearDeduccion') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <label for="nombre">Nombre</label>
                <input type="text" autofocus required name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control">
                @error('nombre')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="porcentaje">Procentaje del Salario %</label>
                <input type="number" autofocus required name="porcentaje" id="porcentaje" value="{{ old('porcentaje') }}" class="form-control">
                @error('porcentaje')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-12">
                <br />
                <br />
                <input type="hidden" nombre="qr_code" id="qr_code">
                <center><button type="submit" class="btn btn-success w-100" >Crear Deduccion</button></center>
            </div>
        </div>
    </form>
</div>
@stop

@push('css')
{{-- mix('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush

@push('js')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<script>
    $(document).ready(function() {
        $('#employe').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "search": "Buscar:"
            }
        });
    });
</script>


@endpush



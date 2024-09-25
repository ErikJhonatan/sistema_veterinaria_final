@extends('adminlte::page')

@section('title', 'VetSys|Empleados')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Empleados &nbsp; <a class="btn btn-primary" href="{{ route('Deduciones') }}">Crear Deduccion<i class="fa fa-plus"></i></a></h1>
@stop
@section('content')
<table class="table" id="employe">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Porcentaje en el sueldo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($deducciones as $d)
            <tr>
                <td>{{ $d->nombre }}</td>
                <td>{{ $d->porcentage}}%</td>
                <td><a href="{{ url('/RRHH/Nomina/Dedduccion/Delete') }}/{{ $d->id }}"  title="Eliminar Dedducion"><i class="fa fa-trash" style="color:red"></i> </a></td>
                
            </tr>
        @endforeach
    </tbody>
</table>
@stop

@push('css')
{{-- mix('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@switch(session('Menss'))
    @case(1)
        <script>
                   toastr.warning('Internal error server');
        </script>
        @break
    @case(2)
    <script>
         toastr.success('Deduccion creada exitosamente');

    </script>
        @break
        @case(3)
        <script>
             toastr.success('Deduccion eliminada exitosamente');
    
        </script>
            @break
    @default
        
@endswitch
@endpush



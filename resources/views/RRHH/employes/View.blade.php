@extends('adminlte::page')

@section('title', 'VetSys|Empleados')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Empleados &nbsp; <a class="btn btn-primary" href="{{ route('CreateEmploye') }}">Crear empleado <i class="fa fa-plus"></i></a></h1>
@stop
@section('content')
<table class="table" id="employe">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employes as $e)
            <tr>
                <td>{{ $e->Name_employe }}</td>
                <td>{{ $e->email}}</td>
                <td>{{ $e->phone }}</td>
                <td><a href="{{ url('/RRHH/Employes/Edit') }}/{{ $e->id }}"  title="Editar usuario"><i class="fa fa-edit" style="color:greenyellow"></i> </a> &nbsp; &nbsp; <a href="{{ url('/RRHH/Employes/Evaluate/') }}/{{ $e->id }}" title="Evaluar empleado"><i class="fa-solid fa-list-check" style="color: rgb(59, 231, 231)"></i></a>&nbsp;&nbsp;<a href="{{ url('RRHH/ViewEvaluations') }}/{{ $e->id }}" title="Ver evaluaciones"><i class="fa-solid fa-list" style="color: #0c0d0d;"></i></a>&nbsp; <a href="" title="Calcular Nomina"><i></i></a> </td>
                
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
            toastr.success('Usuario creado exitosamente');
        </script>
        @break
    @case(2)
    <script>
        toastr.warning('Internal error server');
    </script>
        @break
    @case(3)
    <script>
        toastr.success('Usuario actualizado exitosamente');
    </script>
    @break
    @case(4)
    <script>
        toastr.warning('Ya existe un registro del mes actual');
    </script>
    @break
    @case(5)
    <script>
        toastr.success('Evaluacion caragda exitosamente');
    </script>
    @break
    @default
        
@endswitch
@endpush



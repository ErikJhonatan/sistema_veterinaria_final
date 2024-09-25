@extends('adminlte::page')

@section('title', 'VetSys|Areas de trabajo')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Areas de trabajo &nbsp; <a class="btn btn-primary" href="{{ route('CreateWorkArea') }}">Crear area<i class="fa fa-plus"></i></a></h1>
@stop
@section('content')
<table class="table" id="employe">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($WorkArea as $a)
            <tr>
                <td>{{ $a->name }}</td>
                <td><a href="{{ url('/RRHH/Work/Area/Delete') }}/{{ $a->id }}" ><i class="fa-solid fa-trash" style="color: #f40101;" title="Eliminar Area"></i></a>&nbsp;&nbsp;<a href="{{ url('/RRHH/Work/Area/Edit') }}/{{ $a->id }}"><i class="fa fa-edit" title="Editar Area" style="color:rgb(51, 221, 51)"></i></a></td>
                
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
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
            toastr.success('Area de trabajo agregada exitosamente')
        </script>
        @break
    @case(2)
        <script>
            toastr.error('Internal errro server')
        </script>
        @break
        @case(3)
        <script>
            toastr.warning('Debe seleccionar un area para poder eliminarla')
        </script>
        @break
        @case(4)
        <script>
            toastr.warning('Solo el usuario creador de esta area puede editarla/eliminarla')
        </script>
        @break
        @case(5)
        <script>
            toastr.success('Area eliminada correctamente')
        </script>
        @break
        @case(6)
        <script>
            toastr.success('Area editada correctamente')
        </script>
        @break
    @default
        
@endswitch
@endpush



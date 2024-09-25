@extends('adminlte::page')

@section('title', 'VetSys|Organigramas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Organigramas</h1>
@stop
@section('content')
<table class="table" id="employe">
    <thead>
        <tr>
            <th>Area</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td></td>
                <td></td>
                
            </tr>

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
@endpush



@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@section('content_header')
 <h1 class="m-0 text-dark">   <a href="{{ url('RRHH/ViewEvaluations') }}/{{ $e->id }}" title="ir a la tabla"><i class="fa-solid fa-arrow-left fa-xl"></i></a>&nbsp;<i class="fas fa-box-open"></i> Evaluacion de {{ $e->EmployeName }} del {{ $e->created_at }}</h1>
@stop
@section('content')

    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <center><label for="">Informacion General</label></center>
            </div>
            <div class="col-sm-3">
                <label for="">Nombre del empleado</label>
                <br/>
                <label for="">{{ $e->EmployeName }}</label>
            </div>
            <div class="col-sm-3">
                <label for="">Departamento</label>
                <br/>
                <label for="">{{ $e->WName}}</label>
            </div>
            <div class="col-sm-3">
                <label for="FDE">Fecha de evaluacion</label>
                <br/>
                <label for="">{{ $e->created_at }}</label>
            </div>
            <div class="col-sm-3">
                <label for="">Evaluador</label>
                <br/>
                <label for="">{{ $e->Evaluator }}</label>
            </div>
            <div class="col-sm-12"><center>Desempeño Laboral</center></div>
            <div class="col-sm-3">
                <label for="quality">Calidad de trabajo</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->quality_work }}">
            </div>
            <div class="col-sm-3">
                <label for="quantity">Cantidad de trabajo</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->quantity_work }}">

            </div>
            <div class="col-sm-3">
                <label for="CDP">Cumplimiento de plazos</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->CDP }}">
            </div>
            <div class="col-sm-3">
                <label for="LDM">Logro de metas</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->LDM }}">
            </div>
            <div class="col-sm-12">
                <label for="COMDL">Comentarios</label>
                <input type="text" readonly autofocus class="form-control" value="{{ $e->COMDL }}">
            </div>
            <div class="col-sm-12"><br /> <br /><center>Habilidades tecnicas</center><br/></div>
            <div class="col-sm-6">
                <label for="CT">Competencias tecnicas</label>
                <input type="number" id="CT" readonly autofocus class="form-control"value="{{ $e->CT }}">

            </div>
            <div class="col-sm-6">
                <label for="CDA">Capacidad de aprendizaje</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->CDA }}">
            </div>
            <div class="col-sm-12">
              <label for="COMHT">Comentarios</label>
              <input type="text" readonly autofocus class="form-control" value="{{ $e->COMHT }}"> 
            </div>
            <div class="col-sm-12"><br /> <br/> <center>Habilidades interpersonales</center> <br /></div>
            <div class="col-sm-3">
                <label for="TEE">Trabajo en equipo</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->TEE }}">
            </div>
            <div class="col-sm-3">
                <label for="Comu">Comunicacion</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->Comu }}">
            </div>
            <div class="col-sm-6">
                <label for="LiD">Liderazgo</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->LiD }}">
            </div>
            <div class="col-sm-12">
                <label for="COMHI">Comentarios</label>
                <input type="text" readonly autofocus class="form-control" value="{{ $e->COMHI }}">
            </div>
            <div class="col-sm-12"><br /> <br /><center>Comportamiento y actitud</center> <br /></div>
            <div class="col-sm-3">
                <label for="INI">Iniciativa</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->INI }}">
            </div>
            <div class="col-sm-3">
                <label for="ACT">Actitud</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->ACT }}">
            </div>
            <div class="col-sm-6">
                <label for="FIAB">Fiabilidad</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->FIAB }}">

            </div>
            <div class="col-sm-12">
             <label for="COMCYA">Comentarios</label>
             <input type="text" readonly autofocus class="form-control" value="{{ $e->COMCYA }}">
             @error('COMCYA')
                 <label for="" class="text-danger">{{ $message }}</label>
             @enderror
            </div>
            <div class="col-sm-12"><br/> <br/> <center>Desarrollo Profesional</center><br/></div>
            <div class="col-sm-3">
                <label for="PC">Participacion en capacitaciones</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->PC }}">

            </div>
            <div class="col-sm-3">
                <label for="DH">Desarrollo de habilidades</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->DH }}">
            </div>
            <div class="col-sm-6">
                <label for="FR">Feedback Recibidos</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->FR }}">
            </div>
            <div class="col-sm-12">
                <label for="COMDES">Comentarios</label>
                <input type="text" readonly autofocus class="form-control" value="{{ $e->COMDES }}">
            </div>
            <div class="col-sm-12"><br /> <br/><center>Objetivos y Resultados</center></div>
            <div class="col-sm-6">
                <label for="OE">Objetivos especificos</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->OE }}">
            </div>
            <div class="col-sm-6">
                <label for="IEN">Impacto en el negocio</label>
                <input type="number" readonly autofocus class="form-control" value="{{ $e->IEN }}">
            </div>
        
        <div class="col-sm-12">
            <label for="COMOR">Comentarios</label>
            <input type="text" readonly autofocus class="form-control" value="{{ $e->COMOR }}">
        </div>
        <div class="col-sm-12"><br /> <br/><center>Evaluación 360 Grados (Opcional)</center></div>
        <div class="col-sm-3">
            <label for="AUTO">Autoevaluacion</label>
            <input type="number" readonly autofocus class="form-control" value="{{ $e->AUTO }}">
        </div>
        <div class="col-sm-3">
            <label for="EPP">Evaluacion por pares</label>
            <input type="number" readonly autofocus class="form-control" value="{{ $e->EPP }}">
        </div>
        <div class="col-sm-3">
            <label for="EDSUP">Evaluacion de Superiore</label>
            <input type="number" readonly autofocus class="form-control" value="{{ $e->EDSUP }}">
        </div>
        <div class="col-sm-3">
            <label for="EDSUB">Evaluacion de subordinados</label>
            <input type="number" readonly autofocus class="form-control" value="{{ $e->EDSUB }}">
        </div>
        <div class="col-sm-12">
            <label for="COME360">Comentarios</label>
            <input type="text" readonly autofocus class="form-control" value="{{ $e->COME360 }}">
        </div>
        <div class="col-sm-12"><br /> <br /> <center>Resumen y plan de accion</center></div>
        <div class="col-sm-6">
            <label for="PF">Puntos fuertes</label>
            <input type="text" readonly autofocus class="form-control" value="{{ $e->PF }}">

        </div>
        <div class="col-sm-6">
            <label for="ADM">Areas de mejoras</label>
            <input type="text" readonly autofocus class="form-control" value="{{ $e->ADM }}">
        </div>
        <div class="col-sm-6">
            <label for="OPEPP">Objetivos para el Próximo Período</label>
            <input type="text" readonly autofocus class="form-control" value="{{ $e->OPEPP }}">

        </div>
        <div class="col-sm-6">
            <label for="PDD">Plan de Desarrollo</label>
            <input type="text" readonly autofocus class="form-control" value="{{ $e->PDD }}">
    </div>
@stop

@push('css')
{{-- mix('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
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



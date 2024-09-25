@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Evaluar Empleado</h1>
@stop
@section('content')
<form action="{{ route('EvaluateEmploye') }}" method="post">
    @csrf
    <input type="hidden" value="{{ $Employe->id }}" name="id">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <center><label for="">Informacion General</label></center>
            </div>
            <div class="col-sm-3">
                <label for="">Nombre del empleado</label>
                <br/>
                <label for="">{{ $Employe->name }}</label>
            </div>
            <div class="col-sm-3">
                <label for="">Departamento</label>
                <br/>
                <label for="">{{ $Employe->WN}}</label>
            </div>
            <div class="col-sm-3">
                <label for="FDE">Fecha de evaluacion</label>
                <br/>
                <label for="">@php echo date('d/m/y');@endphp </label>
            </div>
            <div class="col-sm-3">
                <label for="">Evaluador</label>
                <br/>
                <label for="">{{ Auth()->user()->name }}</label>
            </div>
            <div class="col-sm-12"><center>Desempeño Laboral</center></div>
            <div class="col-sm-3">
                <label for="quality">Calidad de trabajo</label>
                <input type="number" required autofocus class="form-control" name="quality" id="quality">
                @error('quality')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-3">
                <label for="quantity">Cantidad de trabajo</label>
                <input type="number" required autofocus class="form-control" name="quantity" id="quantity">
                @error('quantity')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-3">
                <label for="CDP">Cumplimiento de plazos</label>
                <input type="number" required autofocus class="form-control" name="CDP" id="CDP">
                @error('CDP')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-3">
                <label for="LDM">Logro de metas</label>
                <input type="number" required autofocus class="form-control" name="LDM" id="LDM">
                 @error('LDM')
                     <label for="" class="text-danger">{{ $message }}</label>
                 @enderror
            </div>
            <div class="col-sm-12">
                <label for="COMDL">Comentarios</label>
                <input type="text" required autofocus class="form-control" name="COMDL" id="COMDL">
                @error('COMDL')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-12"><br /> <br /><center>Habilidades tecnicas</center><br/></div>
            <div class="col-sm-6">
                <label for="CT">Competencias tecnicas</label>
                <input type="number" id="CT" required autofocus class="form-control" name="CT">
                @error('CT')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="CDA">Capacidad de aprendizaje</label>
                <input type="number" required autofocus class="form-control" name="CDA" id="CDA">
                @error('CDA')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-12">
              <label for="COMHT">Comentarios</label>
              <input type="text" required autofocus class="form-control" name="COMHT" id="COMHT">
              @error('COMHT')
                  <label for="" class="text-danger">{{ $message }}</label>
              @enderror  
            </div>
            <div class="col-sm-12"><br /> <br/> <center>Habilidades interpersonales</center> <br /></div>
            <div class="col-sm-3">
                <label for="TEE">Trabajo en equipo</label>
                <input type="number" required autofocus class="form-control" name="TEE" id="TEE">
                @error('TEE')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-3">
                <label for="Comu">Comunicacion</label>
                <input type="number" required autofocus class="form-control" name="Comu" id="Comu">
                @error('Comu')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-6">
                <label for="LiD">Liderazgo</label>
                <input type="number" required autofocus class="form-control" name="LiD" id="LiD">
                @error('LiD')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-12">
                <label for="COMHI">Comentarios</label>
                <input type="text" required autofocus class="form-control" name="COMHI" id="COMHI">
                @error('COMHI')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-12"><br /> <br /><center>Comportamiento y actitud</center> <br /></div>
            <div class="col-sm-3">
                <label for="INI">Iniciativa</label>
                <input type="number" required autofocus class="form-control" name="INI" id="INI">
                @error('INI')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-3">
                <label for="ACT">Actitud</label>
                <input type="number" required autofocus class="form-control" name="ACT" id="ACT">
                @error('ACT')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-6">
                <label for="FIAB">Fiabilidad</label>
                <input type="number" required autofocus class="form-control" name="FIAB" id="FIAB">
                @error('FIAB')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-12">
             <label for="COMCYA">Comentarios</label>
             <input type="text" required autofocus class="form-control" name="COMCYA" id="COMCYA">
             @error('COMCYA')
                 <label for="" class="text-danger">{{ $message }}</label>
             @enderror
            </div>
            <div class="col-sm-12"><br/> <br/> <center>Desarrollo Profesional</center><br/></div>
            <div class="col-sm-3">
                <label for="PC">Participacion en capacitaciones</label>
                <input type="number" required autofocus class="form-control" name="PC" id="PC">
                @error('PC')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-3">
                <label for="DH">Desarrollo de habilidades</label>
                <input type="number" required autofocus class="form-control" name="DH" id="DH">
                @error('DH')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-6">
                <label for="FR">Feedback Recibidos</label>
                <input type="number" required autofocus class="form-control" name="FR" id="FR">
                @error('FR')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-12">
                <label for="COMDES">Comentarios</label>
                <input type="text" required autofocus class="form-control" name="COMDES" id="COMDES">
                @error('COMDES')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-12"><br /> <br/><center>Objetivos y Resultados</center></div>
            <div class="col-sm-6">
                <label for="OE">Objetivos especificos</label>
                <input type="number" required autofocus class="form-control" name="OE" id="OE">
                @error('OE')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-6">
                <label for="IEN">Impacto en el negocio</label>
                <input type="number" required autofocus class="form-control" name="IEN" id="IEN">
                @error('IEN')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
        
        <div class="col-sm-12">
            <label for="COMOR">Comentarios</label>
            <input type="text" required autofocus class="form-control" name="COMOR" id="COMOR">
            @error('COMOR')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-12"><br /> <br/><center>Evaluación 360 Grados (Opcional)</center></div>
        <div class="col-sm-3">
            <label for="AUTO">Autoevaluacion</label>
            <input type="number" required autofocus class="form-control" name="AUTO" id="AUTO">
            @error('AUTO')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-3">
            <label for="EPP">Evaluacion por pares</label>
            <input type="number" required autofocus class="form-control" name="EPP" id="EPP">
            @error('EPP')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-3">
            <label for="EDSUP">Evaluacion de Superiore</label>
            <input type="number" required autofocus class="form-control" name="EDSUP" id="EDSUP">
            @error('EDSUP')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-3">
            <label for="EDSUB">Evaluacion de subordinados</label>
            <input type="number" required autofocus class="form-control" name="EDSUB" id="EDSUB">
            @error('EDSUB')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-12">
            <label for="COME360">Comentarios</label>
            <input type="text" required autofocus class="form-control" name="COME360" id="COME360">
            @error('COME360')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-12"><br /> <br /> <center>Resumen y plan de accion</center></div>
        <div class="col-sm-6">
            <label for="PF">Puntos fuertes</label>
            <input type="text" required autofocus class="form-control" name="PF" id="PF">
            @error('PF')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-6">
            <label for="ADM">Areas de mejoras</label>
            <input type="text" required autofocus class="form-control" name="ADM" id="ADM">
            @error('ADM')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-6">
            <label for="OPEPP">Objetivos para el Próximo Período</label>
            <input type="text" required autofocus class="form-control" name="OPEPP" id="OPEPP">
            @error('OPEPP')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-6">
            <label for="PDD">Plan de Desarrollo</label>
            <input type="text" required autofocus class="form-control" name="PDD" id="PDD">
            @error('PDD')
            <label for="" class="text-danger">{{ $message }}</label>
        @enderror
        </div>
        <div class="col-sm-12"><br /><br /><br /><center><button type="submit" class="btn btn-success">Evaluar</button></center></div>
        </div>
    </div>
</form>
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



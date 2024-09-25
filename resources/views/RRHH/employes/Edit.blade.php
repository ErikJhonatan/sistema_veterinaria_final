@extends('adminlte::page')

@section('title', 'VetSys|Productos')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Actualizar empleado </h1>
@stop
@section('content')
<div class="card-body">
    <form action="{{ route('EditEmployeForm') }}" method="post">
        <input type="hidden" name="id" value="{{ $employes->id }}">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <label for="name">Nombre</label>
                <input type="text" autofocus required name="name" id="name" value="{{ old('name',$employes->name) }}" class="form-control">
                @error('name')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="phone">Telefono</label>
                <input type="text" autofocus required name="phone" id="phone" value="{{ old('phone',$employes->phone)}}" class="form-control">
                @error('phone')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>
            <div class="col-sm-6">
                <label for="email">Email</label>
                <input type="email" required autofocus name="email" id="email" value="{{ old('email',$employes->email) }}" class="form-control">
                @error('email')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
             <label for="birthdate">Fecha de nacimiento</label>
             <input type="date" required autofocus name="birthdate" id="birthdate" class="form-control" value="{{ $employes->birthdate }}">
             @error('birthdate')
                 <label for="" class="text-danger">{{ $message }}</label>
             @enderror
            </div>
            <div class="col-sm-6">
                <label for="genere">Genero</label>
                <select name="genere" id="genere" class="form-control" autofocus required>
                    <option value="">Seleccione una opcion</option>
                    @foreach ($genere as $g)
                        <option value="{{ $g->id }}" {{ old('genere', $employes->genere) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
                @error('genere')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="address">Direccion de residencia</label>
                <input type="text" name="address" id="address" class="form-control" autofocus required value="{{ old('address',$employes->address) }}">
                @error('address')
                    <label for="" class="text-danger">{{ $mesagge }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="phone_emergency">Telefono de emergencia</label>
                <input type="text" name="phone_emergency" id="phone_emergency" class="form-control" requred autofocus value="{{ old('phone_emergency',$employes->phone_emergency) }}">
                @error('phone_emergency')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
             <label for="employe_title">Puesto/Cargo del empleado</label>
             <select name="employe_title" id="employe_title" class="form-control" autofocus required>
                <option value=""> Seleccione una opcion</option>
                @foreach ($employe_title as $et)
                    <option value="{{ $et->id }}" {{ old('employe_title', $employes->employee_title) == $et->id ? 'selected' : '' }}>{{ $et->name }}</option>
                @endforeach
             </select>
             @error('employe_title')
                 <label for="" class="text-danger">{{ $message }}</label>
             @enderror
            </div>
            <div class="col-sm-6">
                <label for="work_area">Area de trabajo</label>
                <select name="work_area" id="work_area" class="form-control" autofocus required>
                    <option value="">Seleccione una opcion</option>
                    @foreach ($work_area as $wa)
                        <option value="{{ $wa->id }}" {{ old('work_area', $employes->work_area) == $wa->id ? 'selected' : '' }}>{{ $wa->name }}</option>
                    @endforeach
                </select>
                @error('record')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="supervisor">Supervisor</label>
                <select name="supervisor" id="supervisor" autofocus class="form-control">
                    <option value="">Seleccione una opcion</option>
                    @foreach ($sup as $s)
                        <option value="{{ $s->id }}" {{ old('supervisor', $employes->supervisor) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('supervisor')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="FIL">Fecha de inicio de labores</label>
                <input type="date" name="FIL" id="FIL" class="form-control" autofocus required class="form-control" value="{{ old('FIL',$employes->start_work) }}">
                @error('FIL')
                    <label for="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="employment_status">Situacion laboral</label>
                <select name="employment_status" id="employment_status" class="form-control" required autofocus>
                    <option value="">Seleccione una opcion</option>
                    @foreach ($employment_status as $es)
                        <option value="{{ $es->id }}"  {{ old('employment_status', $employes->employment_status) == $es->id ? 'selected' : '' }}>{{ $es->name }}</option>
                    @endforeach
                </select>
                @error('employment_status')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="HIT">Horario laboral (Inicio)</label>
                <input type="time" name="HIT" id="HIT" class="form-control" required autofocus value="{{ old('HIT',$employes->start_working_hours) }}">
                @error('HIT')
                <label for="" class="text-danger">{{ $message }}</label>
                    
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="HET">Horario laboral (Fin)</label>
                <input type="time" name="HET" id="HET" class="form-control" required autofocus value="{{ old('HET',$employes->end_working_hours) }}">
                @error('HET')
                <label for="" class="text-danger">{{ $message }}</label>
                    
                @enderror
            </div>
            <div class="col-sm-6">
            <label for="GDE">Grado de educacion</label>
            <select name="GDE" id="GDE" class="form-control" required autofocus>
                <option value="">Selecione una opcion</option>
                @foreach ($Grade as $g)
                 <option value="{{ $g->id }}"  {{ old('GDE', $employes->degree_education) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>   
                @endforeach
            </select>
            @error('GDE')
                <label for="" class="text-danger">{{ $message }}</label>
            @enderror
            </div>


            <div class="col-sm-6">
                <label for="notes">Notas</label>
                <input type="text" id="notes" name="notes" required autofocus class="form-control" value="{{ old('notes',$employes->notes) }}">
                @error('notes')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div class="col-sm-12">
                <br />
                <br />
                <center><button type="submit" class="btn btn-success">Actualizar Empleado</button></center>
            </div>
        </div>
    </form>
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



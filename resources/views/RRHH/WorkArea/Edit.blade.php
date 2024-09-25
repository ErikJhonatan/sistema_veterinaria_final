@extends('adminlte::page')

@section('title', 'VetSys|Areas de trabajo')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-box-open"></i> Actualizar Area de trabajo </h1>
@stop
@section('content')
<div class="card-body">
    <form action="{{ route('EditWorkAreaForm') }}" method="post">
        <div class="row">
            @csrf
            <input type="hidden" value="{{ $Work_Area->id }}" name="id">
            <div class="col-sm-12">
                <label for="name">Nombre de Area</label>
                <input type="text" name="name" id="name" required autofocus value="{{ old('name',$Work_Area->name) }}" class="form-control">
                @error('name')
                    <label for="" class="text-danger">{{ $message }}</label>
                @enderror 
            </div>
            <div class="col-sm-12">
                <br />
                <br />
                <center><button type="submit" class="btn btn-success">Actualizar area</button></center>
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

@endpush



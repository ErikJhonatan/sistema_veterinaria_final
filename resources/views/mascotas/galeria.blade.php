@extends('adminlte::page')

@section('title', 'VetSys|Mascotas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-dog"></i>Mascotas</h1>
@stop

@section('content')
<div class="flex flex-row">
    <div class="card" style="min-width: 270px;">
        <div class="card-header">
            <img src="/vendor/adminlte/dist/img/mascota.png" alt="Dog Avatar" class="img-circle" style="width: 100px; height: 100px;">
            <h2>{{ $mascota->NombreMascota }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $mascota->Mascota }}</p>
            <p><strong>Identificador:</strong> 00-{{ $mascota->id }}</p>
            <p><strong>Propietario:</strong> {{ $mascota->cliente->Nombre }}</p>
            <p><strong>Especie:</strong> {{ $mascota->especie->Especie }}</p>
            <p><strong>Raza:</strong> {{ $mascota->raza->Raza }}</p>
            <p><strong>Número de Historia:</strong> {{ $mascota->NumeroHistoria }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $mascota->FechaNacimiento }}</p>
            <p><strong>Sexo:</strong> {{ $mascota->Sexo == '1' ? 'M' : 'F'  }}</p>
            <p><strong>Esterilizado:</strong> {{ $mascota->Esterilizado ? 'Si' : 'No' }}</p>
            <p><strong>Asegurado:</strong> {{ $mascota->Asegurado ? 'Si' : 'No' }}</p>
        </div>
    </div>
    <div class="flex flex-column w-100">
        <div class="card card-success">
            <div class="card-header flex flex-row flex-wrap items-center gap-4">
                <a 
                href="{{url('mascota/'.$mascota->id.'/edit')}}"  
                class="flex flex-row items-center gap-1 bg-yellow-400 p-2 rounded"
                >
                    <i class="fas fa-edit"></i>
                    <div>
                        Modificar mascota
                    </div>
                </a>
            
                <a  
                href="{{url('mascota/'.$mascota->id.'/historial-clinico')}}" 
                class="flex flex-row items-center gap-1  p-2 rounded bg-yellow-400"
                >
                    <i class="fas fa-notes-medical"></i> 
                    <div>
                        Historial Clinico
                    </div>
                </a>
            
            
                <a  
                href="{{url('mascota/'.$mascota->id.'/galeria')}}" 
                class="flex flex-row items-center gap-1 bg-yellow-600 p-2 rounded"
                >
                    <i class="fas fa-images"></i>
                    <div>
                        Galeria
                    </div>
                </a>
            
            
                <a  
                href="{{url('mascota/'.$mascota->id.'/historial-compra')}}" 
                class="flex flex-row items-center gap-1  bg-yellow-400 p-2 rounded">
                    <i class="fas fa-shopping-cart"></i>
                    <div>
                        Historial de compra
                    </div>
                </a>
            </div>
        </div>  
        <div id="app" style="padding:5px;">
            <galeria
            :mascota='@json($mascota)'
            />
        </div>
    </div>
</div>


@stop

@push('css')
{{-- mix('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
@endpush

@push('js')
<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script type="module"  src="{{ mix('resources/js/mascota/galeria.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
@endpush
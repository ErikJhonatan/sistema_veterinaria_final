@extends('adminlte::page')

@section('title', 'VetSys|Clientes')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-users"></i> Clientes</h1>
@stop

@php
$clientesPorMesHeads = [
        'Mes',
        'Total',
    ];
$clientesPorProvinciaHeads = [
    'Provincia',
    'Total',
];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
  
];
@endphp

@section('content')
<div class="card card-success">
    <!-- <div class="card-header">
        <h3 class="card-title">Registrar Cliente</h3>
    </div> -->
    <form action="{{ url('cliente') }}" method="post">
        @csrf 
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info" style="width: 100%">
                        <div class="card-header">
                            <h3 class="card-title">Registro de Clientes por mes</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="chart">
                                            <canvas id="barChartmes" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                        </div>
                                    </div>
                        
                                    <div class="col-md-6">
                                        <div class="ml-2">
                                            <x-adminlte-datatable   
                                            :heads="$clientesPorMesHeads" 
                                            head-theme="light" 
                                            striped hoverable bordered compressed   
                                            :config="$config"
                                            id="clientesPorMesTable"
                                            style="height: 100%;width: 100%;"
                                            >
                                                @foreach ($clientesPorMes as $cliente)
                                                    <tr>
                                                        
                                                        <td>{{$cliente->Mes}}</td>
                                                        <td>{{$cliente->Total}}</td>
                                                    
                                                    </tr>
                                                @endforeach
                                            </x-adminlte-datatable>  
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card card-info" style="width: 100%">
                        <div class="card-header">
                            <h3 class="card-title">Registro de Clientes por zona</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="chart">
                                        <canvas id="barChartProvincia" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ml-2">
                                        <x-adminlte-datatable   
                                        :heads="$clientesPorProvinciaHeads" 
                                        head-theme="light" 
                                        striped hoverable bordered compressed   
                                        :config="$config"
                                        id="clientesPorProvinciaTable"
                                        style="height: 100%;width: 100%;"
                                        >
                                            @foreach ($clientesPorProvincia as $cliente)
                                                <tr>
                                                    
                                                    <td>{{$cliente->provincia->Provincia}}</td>
                                                    <td>{{$cliente->Total}}</td>
                                                
                                                </tr>
                                            @endforeach
                                        </x-adminlte-datatable>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>  

@stop


@push('js')

<script>
    $(document).ready(function() {

        function getGraficoPorMes(){
            var barChartCanvas = $('#barChartmes').get(0).getContext('2d');
            var labels = {!! json_encode($clientesPorMes->pluck('Mes'))!!};
            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
            }

            var barChart = new Chart(barChartCanvas, {
                
            type: 'bar', 
            data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($clientesPorMes->pluck('Total'))!!},
                        backgroundColor: [
                            'rgba(0, 123, 255, 0.8)'
                        ],
                        label: "Meses",
                    }]
                },
            options: barChartOptions
            })
        }
        getGraficoPorMes();

        function getGraficoPorProvincia(){
            var barChartCanvas = $('#barChartProvincia').get(0).getContext('2d');
            var labels = {!! json_encode($clientesPorProvincia->pluck('provincia.Provincia'))!!};
            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false,
            }

            var barChart = new Chart(barChartCanvas, {
                
            type: 'bar', 
            data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($clientesPorProvincia->pluck('Total'))!!},
                        backgroundColor: [
                            'rgba(0, 123, 255, 0.8)'
                        ],
                        label: "Provincias",
                    }]
                },
            options: barChartOptions
            })
        }
        getGraficoPorProvincia()

    });
</script>
@endpush
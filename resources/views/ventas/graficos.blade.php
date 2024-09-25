@extends('adminlte::page')

@section('title', 'VetSys | Ventas')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-users"></i> Gestión de ventas</h1>
@stop

@php
$ventas_periodo_heads = [
    'Período',
    'Cantidad',
];
$ventas_ingresos_servicio_heads = [
    'Servicio',
    'Total'
];
$ventas_ingresos_producto_heads = [
    'Producto',
    'Total'
];
$ventas_ranking_mascotas_heads = [
    'Mascota',
    'Total'
];
$ventas_ranking_clientes_heads = [
    'Nombre completo',
    'Total'
];
$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],

];
@endphp

@section('content')
<form action="{{ url('venta') }}" method="post">
    @csrf

    <div class="card card-success">
        <div class="card-body">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ventas totales</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="chart_ventas_totales"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ml-2">
                                <x-adminlte-datatable
                                :heads="$ventas_periodo_heads"
                                head-theme="light"
                                striped hoverable bordered compressed
                                :config="$config"
                                id="ventas_totales"
                                >
                                    @foreach ($ventas_totales as $item)
                                        <tr>
                                            <td>{{ $item->periodo }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ingresos por servicio</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="chart_ingresos_servicio"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ml-2">
                                <x-adminlte-datatable
                                :heads="$ventas_ingresos_servicio_heads"
                                head-theme="light"
                                striped hoverable bordered compressed
                                :config="$config"
                                id="ventas_ingresos_servicio"
                                >
                                    @foreach ($ventas_ingresos_servicio as $item)
                                        <tr>
                                            <td>{{ $item->servicio }}</td>
                                            <td>{{ Prices::symbol() }} {{ Prices::format($item->total) }}</td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ingresos por producto</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="chart_ingresos_producto"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ml-2">
                                <x-adminlte-datatable
                                :heads="$ventas_ingresos_producto_heads"
                                head-theme="light"
                                striped hoverable bordered compressed
                                :config="$config"
                                id="ventas_ingresos_producto"
                                >
                                    @foreach ($ventas_ingresos_producto as $item)
                                        <tr>
                                            <td>{{ $item->producto }}</td>
                                            <td>{{ Prices::symbol() }} {{ Prices::format($item->total) }}</td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ranking de mascotas</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="chart_ranking_mascotas"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ml-2">
                                <x-adminlte-datatable
                                :heads="$ventas_ranking_mascotas_heads"
                                head-theme="light"
                                striped hoverable bordered compressed
                                :config="$config"
                                id="ventas_ranking_mascotas"
                                >
                                    @foreach ($ventas_ranking_mascotas as $item)
                                        <tr>
                                            <td>{{ $item->mascota }}</td>
                                            <td>{{ Prices::symbol() }} {{ Prices::format($item->total) }}</td>
                                        </tr>
                                    @endforeach
                                </x-adminlte-datatable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ranking de clientes</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="chart_ranking_clientes"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ml-2">
                                <x-adminlte-datatable
                                :heads="$ventas_ranking_clientes_heads"
                                head-theme="light"
                                striped hoverable bordered compressed
                                :config="$config"
                                id="ventas_ranking_clientes"
                                >
                                    @foreach ($ventas_ranking_clientes as $item)
                                        <tr>
                                            <td>{{ $item->nombre_completo }}</td>
                                            <td>{{ Prices::symbol() }} {{ Prices::format($item->total) }}</td>
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
</form>
@stop

@push('js')

<script>
    $(document).ready(function() {
        function getColorAleatorio(cantidad) {
            let colores = [];

            for (let i = 0; i < cantidad; i++) {
                let letras = '0123456789ABCDEF'.split('');
                let color = '#';

                for (let x = 0; x < 6; x++) {
                    color += letras[Math.floor(Math.random() * 16)];
                }
                colores.push(color);
            }
            return colores;
        }

        function graficoVentasTotales() {
            let barChartCanvas = $('#chart_ventas_totales').get(0).getContext('2d');
            let labels = {!! json_encode($ventas_totales->pluck('periodo')) !!};
            let barChartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            let barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($ventas_totales->pluck('total')) !!},
                        backgroundColor: getColorAleatorio(labels.length),
                        label: "Ventas",
                    }]
                },
                options: barChartOptions
            })
        }

        function graficoVentasIngresosServicio() {
            let barChartCanvas = $('#chart_ingresos_servicio').get(0).getContext('2d');
            let labels = {!! json_encode($ventas_ingresos_servicio->pluck('servicio'))!!};
            let barChartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            let barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($ventas_ingresos_servicio->pluck('total')) !!},
                        backgroundColor: getColorAleatorio(labels.length),
                        label: "Total en S/.",
                    }]
                },
                options: barChartOptions
            })
        }

        function graficoVentasIngresosProducto() {
            let barChartCanvas = $('#chart_ingresos_producto').get(0).getContext('2d');
            let labels = {!! json_encode($ventas_ingresos_producto->pluck('producto'))!!};
            let barChartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            let barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($ventas_ingresos_producto->pluck('total')) !!},
                        backgroundColor: getColorAleatorio(labels.length),
                        label: "Total en S/.",
                    }]
                },
                options: barChartOptions
            })
        }

        function graficoRankingMascotas() {
            let barChartCanvas = $('#chart_ranking_mascotas').get(0).getContext('2d');
            let labels = {!! json_encode($ventas_ranking_mascotas->pluck('mascota'))!!};
            let barChartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            let barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($ventas_ranking_mascotas->pluck('total')) !!},
                        backgroundColor: getColorAleatorio(labels.length),
                        label: "Total en S/.",
                    }]
                },
                options: barChartOptions
            })
        }

        function graficoRankingClientes() {
            let barChartCanvas = $('#chart_ranking_clientes').get(0).getContext('2d');
            let labels = {!! json_encode($ventas_ranking_clientes->pluck('nombre_completo')) !!};
            let barChartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

            let barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: {!! json_encode($ventas_ranking_clientes->pluck('total')) !!},
                        backgroundColor: getColorAleatorio(labels.length),
                        label: "Total en S/.",
                    }]
                },
                options: barChartOptions
            })
        }

        graficoVentasTotales();
        graficoVentasIngresosServicio();
        graficoVentasIngresosProducto();
        graficoRankingMascotas();
        graficoRankingClientes();
    });
</script>
@endpush

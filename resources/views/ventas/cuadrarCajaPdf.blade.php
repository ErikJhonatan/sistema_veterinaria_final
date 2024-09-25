@php
$heads_ingresos_tipos = [
    'Tipo',
    'Cantidad',
    'Monto',
];
$heads_cierre_caja_periodo = [
    'Medio de pago',
    'Monto',
];

$config = [
    'language' => [
        'url' => '//cdn.datatables.net/plug-ins/2.0.1/i18n/es-ES.json',
    ],
    'searching' => false, // Deshabilita la búsqueda
    'paging' => false, // Deshabilita la paginación
    'info' => false,
    'order' => [],
];

@endphp

<html>
    <head>
        <link rel="stylesheet" href="http://vetsys10.local/vendor/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="http://vetsys10.local/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="http://vetsys10.local/vendor/adminlte/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <!-- Estilos personalizados -->
        <style>
            body {
                font-family: 'Arial', sans-serif;
            }
            .card-header {
                background-color: #007bff;
                color: #fff;
            }
            .card {
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0,0,0,.1);
            }
            .card-title {
                font-size: 20px;
            }
            table {
                width: 100%;
            }
            th, td {
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .text-bold {
                font-weight: bold;
            }
        </style>
    </head>
    <body>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ingresos por tipo de producto/servicio</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <x-adminlte-datatable id="ingresos-tipos" :heads="$heads_ingresos_tipos" head-theme="light" striped hoverable bordered compressed beautify with-buttons :config="$config">

                    @foreach ($resumen_ingresos_tipo as $item)

                        <tr>
                            <td>{{ $item->tipo }}</td>
                            <td>{{ (int) $item->cantidad }}</td>
                            <td>{{ Prices::symbol() }} {{ Prices::format($item->monto) }}</td>
                        </tr>

                    @endforeach

                        <tr class="text-bold">
                            <td>TOTAL</td>
                            <td>{{ (int) $totales_ingresos_tipo['cantidad'] }}</td>
                            <td>{{ Prices::symbol() }} {{ Prices::format($totales_ingresos_tipo['monto']) }}</td>
                        </tr>

                </x-adminlte-datatable>
            </div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Cierre de caja del período</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <x-adminlte-datatable id="cierre-caja-periodo" :heads="$heads_cierre_caja_periodo" head-theme="light" striped hoverable bordered compressed beautify with-buttons :config="$config">

                    @foreach ($resumen_medios_pago as $item)

                        <tr>
                            <td>{{ $item->medio_pago_nombre }}</td>
                            <td>{{ Prices::symbol() }} {{ Prices::format($item->total_importe) }}</td>
                        </tr>

                    @endforeach

                </x-adminlte-datatable>
            </div>
        </div>
    </div>

    </body>
</html>
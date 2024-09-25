@php
$heads = [
    'CANT.',
    'DESCRIPCION',
    'TIPO',
    'VU',
    'SUBTOTAL',
    // 'Impuestos',
    'IMPORTE',
];
$heads_pagos = [
    'FECHA',
    'METODOS DE PAGO',
    'MONTO',

];
$config = [
    'language' => [
        'url' => '',
    ],
    'bPaginate' => false
];
@endphp

<html>
    <head>
        <link rel="stylesheet" href="http://vetsys10.local/vendor/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="http://vetsys10.local/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="http://vetsys10.local/vendor/adminlte/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    </head>

    <body>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 20px;
                background-color: #f8f9fa;
            }

            .card {
                border: 1px solid #dee2e6;
                border-radius: .25rem;
                box-shadow: 0 0.5rem 1rem rgba(0,0,0,.05);
            }

            .card-header {
                background-color: #28a745;
                color: white;
                font-weight: bold;
            }

            .card-body {
                padding: 1.25rem;
            }

            .card-body h5 {
                margin-bottom: 1rem;
                color: #28a745;
            }

            .card-body label {
                display: block;
                margin-bottom: .5rem;
            }

            .card-body .row {
                margin-bottom: 2rem;
            }

            .card-body .row:last-child {
                margin-bottom: 0;
            }

            table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
                border-collapse: collapse;
            }

            table th {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
                background-color: #e9ecef;
                color: #495057;
                font-size: 0.8em;
            }

            table td {
                padding: .75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
                font-size: 0.8em;
            }

            ul {
                padding-left: 0;
                list-style: none;
            }

            ul li {
                display: flex;
                justify-content: space-between;
                margin-bottom: .25rem;
            }

            ul li:last-child {
                font-weight: bold;
                color: #28a745;
            }

            .small-font {
                font-size: 0.8em;
            }

            .header {
                width: 100%;
                margin-bottom: 5px;
            }

            .company-info {
                width: 100%; /* Reduced width to account for padding and border */
                padding: 5px;
                border-bottom: 1px solid #dee2e6;
            }

            .cliente{
                width: 100%; /* Reduced width to account for padding and border */
                padding: 5px;
                border-bottom: 1px solid #dee2e6;
            }

            .info {
                width: calc(50% - 125px); /* Adjust this value as needed */
                display: inline-block;
                vertical-align: top; /* Aligns the content to the top */
            }

            .fiscal {
                background: rgb(236, 234, 234);
                width: 250px;
                text-align: center;
                font-weight: 600;
                border: 1px solid #dee2e6;
                border-radius: .25rem;
                box-shadow: 0 0.5rem 1rem rgba(0,0,0,.05);
                display: inline-block;
                float: right;
            }

            .totales{
                display: inline-block;
                float: right;
                vertical-align: top; /* Aligns the content to the top */
                font-size: 0.8em;
            }
        </style>

        <div class="header">
            <div class="company-info small-font">
                <div class="info">
                    <p>{{ env('NOMBRE_TIENDA') }}</p>
                    <p>{{ env('DIRECCION_TIENDA') }}</p>
                    <p>{{ env('INFORMACION_CONTACTO_TIENDA') }}</p>
                </div>
                <div class="fiscal">
                    <p>RUC {{ env('RUC_TIENDA') }}</p>
                    <p>Comprobante <br> {{ str_pad($comprobante->serie, 3, '0', STR_PAD_LEFT) }}-{{ str_pad($comprobante->comprobante, 8, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <div class="cliente small-font">
            <p>
                <strong>Adquiriente</strong> {{ $comprobante->cliente->Nombre }} {{ $comprobante->cliente->Apellido }}
            </p>
            <p>
                <strong>Documento</strong> {{ $comprobante->cliente->DocumentoIdentidad }}
            </p>
            <p>
                <strong>Email</strong> {{ $comprobante->cliente->Email }}
            </p>
            <p>
                <strong>Dirección</strong> {{ $comprobante->cliente->Direccion ?? '-' }}
            </p>
            <p>
                <strong>Fecha emision</strong> {{ now() }}
            </p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div style="clear: both;">

                    <x-adminlte-datatable id="tabla-items" :heads="$heads" head-theme="light" striped hoverable bordered compressed beautify :config="$config">
                        @foreach ($comprobante->venta->items as $item)
                            <tr>
                                <td><span class="unidades-item">{{ intval($item->cantidad) }}</span></td>
                                <td>{!! !is_null($item->servicio_id) ? ($item->servicio->Servicio ?? '<span class="text-danger">Servicio no encontrado</span>') : ($item->producto->Producto ?? '<span class="text-danger">Producto no encontrado</span>') !!}</td>
                                <td>{{ !is_null($item->servicio_id) ? 'Servicio' : 'Producto' }}</td>
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-unitario">{{ number_format(($item->subtotal / $item->cantidad), 2, ',', '') }}</span></td>
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-subtotal">{{ number_format($item->subtotal, 2, ',', '') }}</span></td>
                                {{-- <td>{{ Prices::symbol() }} <span class="precio-item precio-impuestos">{{ number_format($item->impuestos, 2, ',', '') }}</span></td> --}}
                                <td>{{ Prices::symbol() }} <span class="precio-item precio-total">{{ number_format($item->total, 2, ',', '') }}</span></td>
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>

                    <div id="totales" class="totales">
                        <ul>
                            <li><div>Valor de venta bruto (sin descuentos)</div><div>{{ Prices::symbol() }} <span class="valor-venta-sin-descuentos">{{ Prices::format($valores_venta->valor_bruto) }}</span></div></li>
                            <li><div>Total descuentos</div><div>{{ Prices::symbol() }} <span class="valor-total-descuentos">{{ Prices::format($valores_venta->valor_descuentos) }}</span></div></li>
                            <li><div>Valor de venta (con descuentos)</div><div>{{ Prices::symbol() }} <span class="valor-venta-con-descuentos">{{ Prices::format($valores_venta->valor_con_descuentos) }}</span></div></li>
                            <li><div>Impuestos</div><div>{{ Prices::symbol() }} <span class="valor-impuestos">{{ Prices::format($valores_venta->valor_impuestos) }}</span></div></li>
                            <li><div>TOTAL FINAL</div><div>{{ Prices::symbol() }} <span class="valor-total">{{ Prices::format($valores_venta->valor_total) }}</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div style="clear: both;">

                <x-adminlte-datatable id="tabla-pagos" :heads="$heads_pagos" head-theme="light" striped hoverable bordered compressed beautify :config="$config">
                    @foreach ($comprobante->pagos as $pago)
                        <tr>
                            <td>{{ $pago->created_at }}</td>
                            <td>{{ $pago->medio_pago->FormaDePago }}</td>
                            <td class="{{ $pago->tipo_movimiento_id == 3 ? 'text-danger' : 'text-success' }}">{{ Prices::symbol() }} {{ number_format($pago->importe, 2, ',', '') }}</td>

                        </tr>
                    @endforeach
                </x-adminlte-datatable>

                {{-- <div id="pagos">
                    <ul>
                        <li><div>Dinero recibido</div><div>{{ Prices::symbol() }} <span class="valor-dinero-recibido">{{ number_format($comprobante->dinero_recibido, 2, ',', '') }}</span></div></li>
                        <li><div>Saldo pendiente</div><div>{{ Prices::symbol() }} <span class="valor-saldo-pendiente">{{ number_format($comprobante->saldo_pendiente, 2, ',', '') }}</span></div></li>
                        <li><div>Cambio / vuelto</div><div>{{ Prices::symbol() }} <span class="valor-vuelto">{{ number_format($comprobante->vuelto, 2, ',', '') }}</span></div></li>
                    </ul>
                </div> --}}
            </div>
            </div>
        </div>

    </body>
</html>

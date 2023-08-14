<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pagos administrar</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            text-align: center;
        }

        .respuesta_pop {
            overflow: visible;
            width: 80mm;
            height: auto;
            max-height: none;
            text-align: left;
        }

        .respuesta_pop div {
            font-size: 12px;
        }

        .linea_usuario span {
            padding: 0;
        }

        .datos_usuario {
            padding: 0;
            border: 0;
        }

        .content-imp {
            width: 80mm;
            margin: auto;
        }

        .content-imp .cont-prod:nth-of-type(2n) {
            background: #f5f5f5;
        }

        
    </style>
</head>

<body>
    <div class="content-imp">

        <div class="respuesta_pop">
            <h3>Datos Pedido</h3>
            <div><b>Observaciones Domiciliario:</b> {{ $pago->ultima_observacion }}</div>
            <div><b>Total:</b> ${{ number_format($pago->valor + $pago->descuento - $pago->csto_Dom, 0, '.', '.') }}
            </div>
            <div><b>Domicilio:</b> ${{ number_format($pago->csto_Dom, 0, '.', '.') }}</div>
            @if ($pago->cd_referido != '')
                <div><b>Descuento:</b> ${{ number_format($pago->descuento, 0, '.', '.') }}</div>
                <div><b>Valor a pagar:</b> ${{ number_format($pago->valor, 0, '.', '.') }}</div>
                <div><b>Código Referido:</b> {{ $pago->cd_referido }}</div>
            @else
                <div><b>Valor a pagar:</b> ${{ number_format($pago->valor, 0, '.', '.') }}</div>
            @endif
            <div><b>Tipo Pago:</b> {{ ucfirst($pago->tipo_pago) }}</div>
            <div><b>Fecha Entrega:</b> {{ $pago->fecha_recib }}</div>
            <div><b>Hora Entrega:</b> {{ $pago->hora_cast() }}</div>
            <div><b>Dirección:</b> {{ $pago->direccion }}</div>
            <div><b>Plataforma:</b> {{ $pago->plataforma }}</div>

            <h3>Cliente</h3>
            <div><b>Nombre:</b> {{ $pago->cliente->nombre }}</div>
            <div><b>Apellido:</b> {{ $pago->cliente->apellido }}</div>
            <div><b>Celular:</b> {{ $pago->cliente->celular }}</div>
            <div><b>Email:</b> {{ $pago->cliente->email }}</div>

            <h3>Productos</h3>
            @foreach ($productos as $producto)
                <div class="cont-prod">
                    <div><b>Nombre:</b> {{ $producto->nombre }}</div>
                    <div><b>Und. Medida</b> {{ $producto->descripcion }}</div>
                    <div><b>Cantidad</b> {{ $producto->cantidad }}</div>
                    <div><b>Precio mostrado</b> ${{ number_format($producto->precioMos, 0, '.', '.') }}</div>
                    @if ($producto->apPromocion == '1')
                        <div><b>Aplicó Promoción</b> SI</div>
                    @endif
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    <script type="text/javascript">
        window.print();
        //window.close();
    </script>
</body>

</html>

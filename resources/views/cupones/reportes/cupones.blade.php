<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table>
        <tr>
            <th>Cupon</th>
            <th>Cliente</th>
            <th>Id Pedido</th>
            <th>Monto Original</th>
            <th>Descuento</th>
            <th>Costo Domicilio</th>
            <th>Monto Final</th>
            <th>Fecha</th>
        </tr>
    @foreach ($cupones as $cupon)
        <tr>
            <td>{{ $cupon->cupon }}</td>
            <td>{{ $cupon->cliente }}</td>
            <td>{{ $cupon->idpago }}</td>
            <td>{{ $cupon->montoOriginal }}</td>
            <td>{{ $cupon->descuento }}</td>
            <td>{{ $cupon->csto_Dom }}</td>
            <td>{{ $cupon->montoFinal }}</td>
            <td>{{ $cupon->fecha }}</td>
        </tr>
    @endforeach
    </table>
</body>

</html>

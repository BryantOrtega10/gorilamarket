<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table>
        <tr>
            <th>Estado</th>
            <th>Id Pago</th>
            <th>Fecha despacho</th>
            <th>Hora despacho</th>
            <th>Cliente</th>
            <th>Dirección</th>
            <th>Barrio</th>
            <th>Celular</th>
            <th>Domicilario</th>
        </tr>
    @foreach ($pagos as $pago)
        <tr>
            <td>{{ $pago->estado }}</td>
            <td>{{ $pago->idpago }}</td>
            <td>{{ $pago->fecha_recib }}</td>
            <td>{{ $pago->hora_recib }}</td>
            <td>{{ $pago->nombre_cliente }} {{$pago->apellido_cliente}}</td>
            <td>{{ $pago->direccionCompleta }}</td>
            <td>{{ $pago->barrio }}</td>
            <td>{{ $pago->celular }}</td>
            <td>{{ $pago->nombre_domiciliario }} {{$pago->apellido_domiciliario}}</td>
        </tr>
    @endforeach
    </table>
</body>

</html>

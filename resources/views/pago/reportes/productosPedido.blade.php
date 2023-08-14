<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table>
        <tr>
            <th>Id Producto</th>
            <th>Cliente Nombre</th>
            <th>Cliente Apellido</th>
            <th>Código de Barras</th>
            <th>Descripción producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
        </tr>
    @foreach ($productos as $producto)
        <tr>
            <td>{{ $producto->idproducto }}</td>
            <td>{{ $pago->cliente->nombre }}</td>
            <td>{{ $pago->cliente->apellido }}</td>
            <td>="{{ $producto->cd_barras }}"</td>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->cantidad }}</td>
            <td>{{ $producto->precioMos }}</td>
        </tr>
    @endforeach
    </table>
</body>

</html>

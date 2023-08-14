<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table>
        <tr>
            <th>Id Cliente</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Código Referido</th>
            <th>Referidos</th>
        </tr>
    @foreach ($clientes as $cliente)
        <tr>
            <td>{{ $cliente->idcliente }}</td>
            <td>{{ $cliente->nombre }}</td>
            <td>{{ $cliente->apellido }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->celular }}</td>
            <td>{{ $cliente->fijo }}</td>
            <td>{{ $cliente->misreferidos }}</td>
        </tr>
    @endforeach
    </table>
</body>

</html>

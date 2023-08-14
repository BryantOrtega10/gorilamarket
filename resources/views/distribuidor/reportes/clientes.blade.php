<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <table>
        <tr>
            <th>ID Distribuidor</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Celular</th>
            <th>Estado</th>
            <th>Num. Pedidos</th>
            <th>Direcciones</th>
        </tr>
    @foreach ($clientes as $cliente)
        <tr>
            <td>{{$cliente->idcliente}}</td>
            <td>{{$cliente->nombre}}</td>
            <td>{{$cliente->apellido}}</td>
            <td>{{$cliente->email}}</td>
            <td>{{$cliente->celular}}</td>
            <td>{{($cliente->estado == "1" ? "Activo" : "Inactivo")}}</td>
            <td>{{$cliente->no_pedidos}}</td>
            <td>{{$cliente->direccionesG}}</td>
        </tr>
    @endforeach
    </table>
</body>

</html>

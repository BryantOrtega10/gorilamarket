<!DOCTYPE html>
<html>
<head>
    <title>Gorila Market</title>
</head>
<body>
    <h1>Nuevo producto sugerido</h1>
    <p>Se ha sugerido un producto al efectuar la compra<br>
        <b>Sugerencia:</b> {{ $mailData['sugerencia'] }}<br>
        <b>Email:</b> {{ $mailData['email'] }}<br>
    </p>
</body>
</html>
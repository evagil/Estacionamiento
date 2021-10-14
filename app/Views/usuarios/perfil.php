<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estacionamiento</title>
</head>
<body>
    <h1>Hola <?= esc(session()->get('dni')) ?></h1>
    <button onclick="location.href = '<?= esc(base_url('usuarios/salir')) ?>'">Salir</button>
</body>
</html>

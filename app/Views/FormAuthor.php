<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Autor</title>
</head>
<body>
    <h2>Registrar Autor</h2>
    <form action="<?= base_url('autores/guardar') ?>" method="post">
    <?= csrf_field() ?>
    ...
        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre" maxlength="200" required><br><br>

        <label for="apellidos">Apellidos</label><br>
        <input type="text" name="apellidos" id="apellidos" maxlength="200" required><br><br>

        <label for="nacionalidad">Nacionalidad</label><br>
        <input type="text" name="nacionalidad" id="nacionalidad" maxlength="100" required><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
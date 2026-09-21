<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php
    $nombre    = $nombre    ?? '';
    $apellidos = $apellidos ?? '';
    $rol       = $rol       ?? '';
    ?>

    <h2>Bienvenido, <?= esc($nombre) ?> <?= esc($apellidos) ?></h2>
    <p>Rol: <?= esc($rol) ?></p>
    <nav>
        <ul>
            <li><a href="<?= base_url('libreria/catalogo') ?>">Catálogo de libros</a></li>
            <li><a href="<?= base_url('libreria/carrito') ?>">Mi carrito</a></li>
            <?php if ($rol === 'administrador'): ?>
                <li><a href="<?= base_url('libros/nuevo') ?>">Registrar libro</a></li>
                <li><a href="<?= base_url('autores/nuevo') ?>">Registrar autor</a></li>
            <?php endif; ?>
            <li><a href="<?= base_url('logout') ?>">Cerrar sesión</a></li>
        </ul>
    </nav>
</body>           
</html>
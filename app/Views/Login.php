<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    <?php if (session()->getFlashdata('msg_error')): ?>
        <p><?= esc(session()->getFlashdata('msg_error')) ?></p>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>

    <a href="<?= site_url('registro') ?>">Crear una cuenta</a>
</body>
</html>
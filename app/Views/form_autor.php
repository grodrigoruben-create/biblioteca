<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Autor</title>
</head>
<body>
    <h2>Registrar Autor</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('exito')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('exito')) ?></p>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div style="color:red;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('Administrador/Autor/guardar') ?>" method="post">
        <?= csrf_field() ?>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= old('nombre') ?>" required><br><br>

        <label>Apellidos:</label><br>
        <input type="text" name="apellidos" value="<?= old('apellidos') ?>" required><br><br>

        <label>Nacionalidad:</label><br>
        <input type="text" name="nacionalidad" value="<?= old('nacionalidad') ?>"><br><br>

        <button type="submit">Guardar Autor</button>
    </form>

    <p><a href="<?= site_url('dashboard') ?>">Volver al panel</a></p>
</body>
</html>
<?php
/** @var array $autores */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Libro</title>
</head>
<body>
    <h2>Registrar Libro</h2>

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

    <form action="<?= site_url('Administrador/Libro/guardar') ?>" method="post">
        <?= csrf_field() ?>

        <label>Título:</label><br>
        <input type="text" name="titulo" value="<?= old('titulo') ?>" required><br><br>

        <label>ISBN:</label><br>
        <input type="text" name="isbn" value="<?= old('isbn') ?>" required><br><br>

        <label>Formato:</label><br>
        <select name="formato" required>
            <option value="pasta dura">Pasta dura</option>
            <option value="rustico">Rústico</option>
            <option value="digital">Digital</option>
        </select><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" min="0" name="precio" value="<?= old('precio') ?>" required><br><br>

        <label>Stock:</label><br>
        <input type="number" min="0" name="stock" value="<?= old('stock') ?>" required><br><br>

        <label>Autores:</label><br>
        <?php if (empty($autores)): ?>
            <p>
                No hay autores registrados todavía.
                <a href="<?= site_url('Administrador/Autor/crear') ?>">Crea uno primero</a>.
            </p>
        <?php else: ?>
            <?php foreach ($autores as $autor): ?>
                <label>
                    <input type="checkbox" name="autores[]" value="<?= $autor['id_autor'] ?>">
                    <?= esc($autor['nombre'] . ' ' . $autor['apellidos']) ?>
                </label><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <br>

        <button type="submit">Guardar Libro</button>
    </form>

    <p><a href="<?= site_url('dashboard') ?>">Volver al panel</a></p>
</body>
</html>
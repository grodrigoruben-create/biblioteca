<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar obra</title>
</head>
<body>
    <h2>Registrar Obra</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="color:red;"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('libros/guardar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label for="titulo">Título</label><br>
        <input type="text" name="titulo" id="titulo" maxlength="200" required value="<?= old('titulo') ?>">
        <br><br>

        <label for="portada">Portada</label><br>
        <input type="file" name="portada" id="portada" accept="image/*">
        <br><br>

        <label for="autor_id">Autores</label><br>
        <?php $autores = $autores ?? []; ?>
        <select name="autor_id[]" id="autor_id" multiple required>
            <?php foreach ($autores as $a): ?>
                <option value="<?= $a['id_autor'] ?>">
                    <?= esc($a['nombre'] . ' ' . $a['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <button type="submit">Guardar y continuar con los formatos</button>
    </form>
</body>
</html>
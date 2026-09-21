<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar libro</title>
</head>

<body>

    <h2>Registrar libro</h2>

    <form action="<?= base_url('libros/guardar') ?>" method="post" enctype="multipart/form-data">

        <label for="titulo">Título</label><br>
        <input type="text" name="titulo" id="titulo" maxlength="200" required>
        <br><br>

        <label for="isbn">ISBN</label><br>
        <input type="text" name="isbn" id="isbn" maxlength="17" required>
        <br><br>

        <label for="formato">Formato</label><br>
        <select name="formato" id="formato" required>
            <option value="pasta dura">Pasta Dura</option>
            <option value="rustico">Rústico</option>
            <option value="digital">Digital</option>
        </select>
        <br><br>

        <label for="precio">Precio</label><br>
        <input type="number" name="precio" id="precio" step="0.01" min="0" required>
        <br><br>

        <label for="stock">Stock</label><br>
        <input type="number" name="stock" id="stock" min="0" required>
        <br><br>

        <label for="portada">Portada</label><br>
        <input type="file" name="portada" id="portada" accept="image/*">
        <br><br>

        <label for="autor_id">Autores</label><br>

        <?php $autores = $autores ?? []; ?>

        <select name="autor_id[]" id="autor_id" multiple required>
            <?php foreach ($autores as $a): ?>
                <option value="<?= $a['id'] ?>">
                    <?= esc($a['nombre'] . ' ' . $a['apellidos']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <button type="submit">Guardar</button>

    </form>

</body>
</html>
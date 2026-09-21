<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formatos de <?= esc($libro['titulo'] ?? '') ?></title>
</head>
<body>
    <h2>Formatos disponibles para: <?= esc($libro['titulo'] ?? '') ?></h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div style="color:green;"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div style="color:red;"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <h3>Ya agregados</h3>
    <?php if (empty($variantes)): ?>
        <p>Todavía no has agregado ningún formato para esta obra.</p>
    <?php else: ?>
        <table border="1" cellpadding="6">
            <thead>
                <tr><th>Formato</th><th>ISBN</th><th>Precio</th><th>Stock</th></tr>
            </thead>
            <tbody>
                <?php foreach ($variantes as $v): ?>
                    <tr>
                        <td><?= esc($v['formato']) ?></td>
                        <td><code><?= esc($v['isbn']) ?></code></td>
                        <td>$<?= number_format($v['precio'], 2) ?></td>
                        <td><?= (int) $v['stock'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h3>Agregar otro formato</h3>
    <form action="<?= base_url('libros/' . ($libro['id_libro'] ?? '') . '/formatos/guardar') ?>" method="post">
        <?= csrf_field() ?>

        <label for="formato_id">Formato</label><br>
        <select name="formato_id" id="formato_id" required>
            <?php foreach (($formatos ?? []) as $f): ?>
                <option value="<?= $f['id_formato'] ?>"><?= esc($f['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="isbn">ISBN</label><br>
        <input type="text" name="isbn" id="isbn" maxlength="17" required>
        <br><br>

        <label for="precio">Precio</label><br>
        <input type="number" name="precio" id="precio" step="0.01" min="0" required>
        <br><br>

        <label for="stock">Stock</label><br>
        <input type="number" name="stock" id="stock" min="0" required>
        <br><br>

        <button type="submit">Agregar formato</button>
    </form>

    <br>
    <a href="<?= base_url('libreria/catalogo') ?>">Terminar e ir al catálogo</a>
</body>
</html>
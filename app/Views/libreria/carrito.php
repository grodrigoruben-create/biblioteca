<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito de Libros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/
bootstrap.min.css">
</head>
<body class="container py-4">
    <h1 class="mb-4">Mi Carrito de Compras</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php
    $carrito = $carrito ?? [];
    $total = array_sum(array_column($carrito, 'subtotal'));
    ?>
    <?php if (empty($carrito)): ?>
        <div class="alert alert-warning">
            No tienes libros en tu carrito. <a href="<?= site_url('libreria/catalogo') ?>">Volver al catálogo</a>.
        </div>
    <?php else: ?>
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ISBN</th>
                    <th>Título / Autor</th>
                    <th>Formato</th>
                    <th>Precio U.</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $key => $item): ?>
                    <tr>
                        <td><code><?= esc($item['isbn']) ?></code></td>
                        <td>
                            <strong><?= esc($item['titulo']) ?></strong><br>
                            <small class="text-muted"><?= esc($item['autor']) ?></small>
                        </td>
                        <td><span class="badge bg-info text-dark"><?= esc($item['formato']) ?></span></td>
                        <td>$<?= number_format($item['precio'], 2) ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                        <td>
                            <a href="<?= site_url('libreria/carrito/eliminar/' . $key) ?>" class="btn btn-danger btn-sm">Quitar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">Total a Pagar:</th>
                    <th>$<?= number_format($total, 2) ?></th>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <div class="d-flex justify-content-between">
            <a href="<?= site_url('libreria/catalogo') ?>" class="btn btn-outline
                secondary">Continuar explorando</a>
            <a href="<?= site_url('libreria/carrito/vaciar') ?>" class="btn btn-outline
                danger">Vaciar Carrito</a>
        </div>
    <?php endif; ?>
</body>
</html>
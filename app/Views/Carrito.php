<?php
/** @var float $total */
/** @var array $carrito */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de libros</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>

<body class="container py-4">

    <h1 class="mb-4">Mi Carrito de Compras <i class="bi bi-cart4"></i></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($carrito)): ?>

        <div class="alert alert-warning">
            No tienes libros en tu carrito.
            <a href="<?= site_url('libreria/catalogo') ?>">
                Volver al catálogo
            </a>.
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

                <?php foreach ($carrito as $itemkey => $item): ?>

                    <tr>

                        <td>
                            <?= esc($item['isbn']) ?>
                        </td>

                        <td>
                            <?= esc($item['titulo']) ?>
                            /
                            <?= esc($item['autor'] ?? 'No especificado') ?>
                        </td>

                        <td>
                            <?= esc($item['formato']) ?>
                        </td>

                        <td>
                            $<?= number_format($item['precio'], 2) ?>
                        </td>

                        <td>
                            <?= esc((string) $item['cantidad']) ?>
                        </td>

                        <td>
                            $<?= number_format($item['subtotal'], 2) ?>
                        </td>

                        <td>
                            <a
                                href="<?= site_url('libreria/carrito/eliminar/' . $itemkey) ?>"
                                class="btn btn-sm btn-outline-danger"
                            >
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">
                        Total a Pagar:
                    </th>

                    <th>
                        $<?= number_format($total, 2) ?>
                    </th>

                    <th></th>
                </tr>
            </tfoot>

        </table>

        <div class="d-flex justify-content-between">

            <a
                href="<?= site_url('libreria/catalogo') ?>"
                class="btn btn-outline-secondary"
            >
                Continuar explorando
            </a>

            <a
                href="<?= site_url('libreria/carrito/vaciar') ?>"
                class="btn btn-outline-danger"
            >
                Vaciar Carrito
            </a>

        </div>

    <?php endif; ?>

</body>

</html>
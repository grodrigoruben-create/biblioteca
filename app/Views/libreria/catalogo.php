<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería Universitaria - Catálogo Paginado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .book-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #ffffff;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
        }
        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            min-height: 2.6rem;
        }
        .book-price { font-size: 1.25rem; font-weight: 800; color: #27ae60; }
        .isbn-badge { font-family: monospace; font-size: 0.75rem; background-color: #e9ecef; }
        .pagination-container ul {
            display: flex; list-style: none; justify-content: center; gap: 4px; padding-left: 0;
        }
        .pagination-container li a, .pagination-container li span {
            padding: 0.375rem 0.75rem; color: #0d6efd; background-color: #fff;
            border: 1px solid #dee2e6; border-radius: 0.375rem; text-decoration: none;
        }
        .pagination-container li.active span { color: #fff; background-color: #0d6efd; }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Librería Académica</h1>
            <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-primary">
                Ver Carrito (<?= count(session()->get('libro_carrito') ?? []) ?>)
            </a>
        </div>
    </header>
    <main class="container py-2">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            <?php foreach (($libros ?? []) as $libro): ?>
                <div class="col">
                    <div class="card h-100 book-card shadow-sm p-3">
                        <span class="badge isbn-badge w-auto me-auto mb-2">ISBN: <?= esc($libro['isbn']) ?></span>
                        <!-- Validamos si existe la portada, de lo contrario mostramos una imagen por defecto -->
                        <?php $rutaImagen = !empty($libro['portada']) ? base_url('uploads/' . $libro['portada']) : base_url('assets/img/default-book.png'); ?>

                        <img src="<?= $rutaImagen ?>" class="card-img-top img-fluid mb-3" alt="Portada de <?= esc($libro['titulo']) ?>" style="max-height: 250px; object-fit: contain;">

                        <h2 class="book-title"><?= esc($libro['titulo']) ?></h2>
                        <p class="text-muted small">Autor: <?= esc($libro['autor']) ?></p>
                        <div class="book-price mb-2">$<?= number_format($libro['precio'], 2) ?> MXN</div>
                        <form action="<?= site_url('libreria/carrito/agregar') ?>" method="post" class="mt-auto">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_libro" value="<?= $libro['id_libro'] ?>">
                            <input type="hidden" name="formato" value="<?= esc($libro['formato']) ?>">
                            <p class="mb-2">
                                <span class="badge bg-secondary"><?= esc($libro['formato']) ?></span>
                            </p>
                            <div class="row g-2 mb-2">
                                <div class="col-12">
                                    <input type="number" name="cantidad" value="1" min="1" max="<?= $libro['stock'] ?>" class="form-control form-control-sm">
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm w-100" type="submit" <?= $libro['stock'] <= 0 ? 'disabled' : '' ?>>
                                <?= $libro['stock'] > 0 ? 'Agregar al Carrito' : 'Agotado' ?>
                            </button>
                        </form>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="d-flex justify-content-center pagination-container">
            <?= ($pager ?? service('pager'))->links('default', 'bootstrap_pagination') ?>
        </div>
    </main>
</body>
</html>
<?php
/** @var \CodeIgniter\Pager\PagerInterface $pager */
/** @var array $libros */
?>
<! DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería Universitaria - Catálogo Paginado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>
<style>
    body {
        background-color: #f8f9fa;
    }   
    book-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #ffffff;
    }
    book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
    }
    book-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        min-height: 2.6rem;
    }
    book-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #27ae60;
    }
    isbn-badge {
        font-family: monospace;
        font-size: 0.75rem;
        background-color: #e9ecef;
        padding: 2px 6px;
        border-radius: 3px;
    }
    pagination-container ul {
        display: flex;
        list-style: none;
        justify-content: center;
        gap: 4px;
        padding-left: 0;
    }
    pagination-container li a, .pagination-container li span {
        padding: 0.375rem 0.75rem;
        color: #0d6efd;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        text-decoration: none;
    }
    pagination-container li.active span {
        color: #fff;
        background-color: #0d6efd;
    }
</style>
</head>
<body>
    <header class="bg-dark text-white py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0">Librería Universitaria</h1>

            </a>
                        <a
                href="<?= site_url('login') ?>"
                class="btn btn-outline-secondary"
            >
                Iniciar seccion
            </a>
                        </a>
                        <a
                href="<?= base_url('logout') ?>"
                class="btn btn-outline-secondary"
            >
                Cerrar sesión
            </a>
            <form 
            <label>
                <input type="radio" name="filtro" value="1" checked> Buscar por autor
            </label>
            <label>
                <input type="radio" name="filtro" value="2"> Buscar por título
            </label>

            <div id="filtro-autor">
                <input type="text" name="nombre" placeholder="Nombre del autor">
                <input type="text" name="apellido" placeholder="Apellidos del autor">
            </div>

            <div id="filtro-titulo">
                <input type="text" name="titulo" placeholder="Título del libro">
            </div>

            <button type="submit">Buscar</button>

            <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-primary">
                <i class="bi bi-cart4"></i> (<?= count(session()->get('libro_carrito') ?? []) ?>)
            </a>
        </div>
    </header>
    <main class="container py-2">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            <?php foreach ($libros as $libro): ?>
                <div class="col">
                    <div class="card h-100 book-card shadow-sm p-3">
                        <?php if (!empty($libro['portada'])): ?>
                            <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                alt="Portada de <?= esc($libro['titulo']) ?>"
                                class="img-fluid mb-2" style="height:200px; object-fit:cover;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center mb-2 bg-light"
                                style="height:200px;">
                                <span class="text-muted small">Sin portada</span>
                            </div>
                        <?php endif; ?>

                        <span class="badge isbn-badge w-auto me-auto mb-2">ISBN: <?= esc($libro['isbn']) ?></span>
                        ...
                        <h2 class="book-title"><?= esc($libro['titulo']) ?></h2>
                        <p class="text-muted small">
                            Autor:
                            <?php if (!empty($libro['autor_nombre'])): ?>
                                <?= esc($libro['autor_nombre'] . ' ' . $libro['autor_apellidos']) ?>
                            <?php else: ?>
                                No especificado
                            <?php endif; ?>
                        </p>
                        <div class="book-price mb-2">$<?= number_format($libro['precio'], 2) ?> MXN</div>
                        <form action="<?= site_url('libreria/carrito/agregar') ?>" method="post" class="mt-auto">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $libro['id'] ?>">
                            <div class="row g-2 mb-2">
                                <div class="col-7">
                                    <select name="formato" class="form-select form-select-sm">
                                        <option value="Físico Rústica">Rústica</option>
                                        <option value="Tapa Dura">Tapa Dura</option>
                                        <option value="Digital PDF">PDF Digital</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input type="number" name="cantidad" min="1" max="<?= $libro['stock'] ?>" value="1" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm w-100">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php if (isset($pager)): ?>
    <nav aria-label="Page navigation example">
        <?= $pager->links('default', 'default_full') ?>
    </nav>
    <?php endif; ?>
</body>

<header class="bg-dark text-white py-3 mb-4 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">¡El conocimiento es poder!</h1>

        <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-primary">
            Ver Carrito (<?= count(session()->get('libro_carrito') ?? []) ?>)
        </a>
    </div>
</header>
</body>
</html>
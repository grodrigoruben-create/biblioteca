<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Librería Universitaria</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <?php
    $nombre    = $nombre    ?? 'Usuario';
    $apellidos = $apellidos ?? '';
    $rol       = $rol       ?? 'cliente';
    ?>

    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-book-half"></i> Librería Universitaria</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3 small">Hola, <strong><?= esc($nombre) ?></strong></span>
                <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Tarjeta de Bienvenida -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="fw-bold mb-1">Bienvenido, <?= esc($nombre) ?> <?= esc($apellidos) ?></h2>
                            <p class="text-muted mb-0">Panel de control de tu cuenta</p>
                        </div>
                        <div>
                            <span class="badge bg-<?= $rol === 'administrador' ? 'danger' : 'primary' ?> fs-6 text-uppercase px-3 py-2">
                                <?= esc($rol) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Menú de Opciones -->
                <div class="row g-3">
                    
                    <!-- Opción: Catálogo -->
                    <div class="col-md-6">
                        <div class="card h-150 shadow-sm border-0 text-center p-3">
                            <div class="card-body">
                                <i class="bi bi-shop text-primary fs-1 mb-2"></i>
                                <h4 class="h5 card-title">Catálogo de Libros</h4>
                                <p class="card-text text-muted small">Explora todos los libros disponibles y agrégalos a tu carrito.</p>
                                <a href="<?= site_url('libreria') ?>" class="btn btn-primary btn-sm w-100">Ver Catálogo</a>
                            </div>
                        </div>
                    </div>

                    <!-- Opción: Carrito -->
                    <div class="col-md-6">
                        <div class="card h-150 shadow-sm border-0 text-center p-3">
                            <div class="card-body">
                                <i class="bi bi-cart3 text-success fs-1 mb-2"></i>
                                <h4 class="h5 card-title">Mi Carrito</h4>
                                <p class="card-text text-muted small">Revisa los ejemplares seleccionados y gestiona tu compra.</p>
                                <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-success btn-sm w-100">Ir al Carrito</a>
                            </div>
                        </div>
                    </div>

                    <!-- Opciones exclusivas de Administrador -->
                    <?php if ($rol === 'administrador'): ?>
                        <div class="col-12">
                            <div class="card shadow-sm border-warning bg-white p-3">
                                <div class="card-body">
                                    <h5 class="text-warning-emphasis mb-3"><i class="bi bi-shield-lock"></i> Panel de Administración</h5>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <a href="<?= site_url('Administrador/Libro/crear') ?>" class="btn btn-outline-dark w-100 text-start">
                                                <i class="bi bi-plus-circle me-2"></i> Registrar Nuevo Libro
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="<?= site_url('Administrador/Autor/crear') ?>" class="btn btn-outline-dark w-100 text-start">
                                                <i class="bi bi-person-plus me-2"></i> Registrar Nuevo Autor
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
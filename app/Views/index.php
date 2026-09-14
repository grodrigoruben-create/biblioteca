<?php
/** @var \CodeIgniter\Pager\PagerInterface $pager */
/** @var array $libros */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería Universitaria - Catálogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }   
        .book-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: #ffffff;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
        }
        .book-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            /* Usar line-clamp es mejor que min-height para títulos largos */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .book-price { font-size: 1.25rem; font-weight: 800; color: #27ae60; }
        .isbn-badge { font-family: monospace; font-size: 0.75rem; background-color: #e9ecef; color: #495057; padding: 3px 7px; border-radius: 4px; }
        
        /* Ocultar secciones de filtro mediante CSS en lugar de inline styles */
        .filtro-seccion { display: none; }
        .filtro-activo { display: block; }
    </style>
</head>
<body>
    <header class="bg-dark text-white py-3 mb-4 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h1 class="h4 mb-0 m-0">Librería Universitaria</h1>

            <!-- Barra de Búsqueda -->
            <form action="<?= site_url('libreria/buscar') ?>" method="get" class="d-flex align-items-center flex-grow-1 mx-lg-4">
                <select id="tipoFiltro" name="filtro" class="form-select form-select-sm w-auto me-2">
                    <option value="titulo" selected>Por Título</option>
                    <option value="autor">Por Autor</option>
                </select>

                <!-- Input Título -->
                <div id="filtro-titulo" class="filtro-seccion filtro-activo flex-grow-1 me-2">
                    <input type="text" name="titulo" class="form-control form-control-sm" placeholder="Ej: Cien años de soledad...">
                </div>

                <!-- Inputs Autor -->
                <div id="filtro-autor" class="filtro-seccion flex-grow-1 me-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre">
                        <input type="text" name="apellido" class="form-control" placeholder="Apellido">
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-light btn-sm"><i class="bi bi-search"></i> Buscar</button>
            </form>

            <!-- Botones de Sesión y Carrito -->
            <div class="d-flex gap-2">
                <!-- Asumo que tienes un sistema de auth. Si no hay sesión iniciada, mostramos 'Iniciar Sesión' -->
                <?php if(!session()->get('usuario_id')): ?>
                    <a href="<?= site_url('login') ?>" class="btn btn-outline-light btn-sm">Iniciar sesión</a>
                <?php else: ?>
                    <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
                <?php endif; ?>
                
                <a href="<?= site_url('libreria/carrito') ?>" class="btn btn-primary btn-sm position-relative">
                    <i class="bi bi-cart4"></i>
                    <?php $cantCarrito = count(session()->get('libro_carrito') ?? []); ?>
                    <?php if($cantCarrito > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $cantCarrito ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </header>

    <main class="container py-2">
        <!-- Alertas -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Grid de Libros -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            <?php foreach ($libros as $libro): ?>
                <div class="col">
                    <div class="card h-100 book-card p-3 d-flex flex-column">
                        
                        <!-- Portada -->
                        <?php if (!empty($libro['portada'])): ?>
                            <img src="<?= base_url('uploads/portadas/' . $libro['portada']) ?>"
                                 alt="Portada de <?= esc($libro['titulo']) ?>"
                                 class="img-fluid rounded mb-3" style="height:200px; object-fit:contain; background-color:#f8f9fa;">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center mb-3 bg-light rounded" style="height:200px;">
                                <i class="bi bi-book text-secondary" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="mb-2">
                            <span class="badge isbn-badge">ISBN: <?= esc($libro['isbn']) ?></span>
                        </div>
                        
                        <h2 class="book-title mb-1" title="<?= esc($libro['titulo']) ?>"><?= esc($libro['titulo']) ?></h2>
                        
                        <!-- Autor: Nota, esto asume que en el controlador hiciste un JOIN y enviaste 'autor_nombre' -->
                        <p class="text-muted small mb-3">
                            <i class="bi bi-pen"></i> 
                            <?= !empty($libro['autor_nombre']) ? esc($libro['autor_nombre'] . ' ' . ($libro['autor_apellidos'] ?? '')) : 'Autor Múltiple / N/A' ?>
                        </p>
                        
                        <div class="book-price mb-3 mt-auto">$<?= number_format($libro['precio'], 2) ?> MXN</div>
                        
                        <!-- Formulario de Agregar al Carrito -->
                        <!-- FIX: Cambiado a site_url('libreria/carrito/add') basado en Routes.php -->
                        <form action="<?= site_url('libreria/carrito/add') ?>" method="post" class="mt-auto">
                            <?= csrf_field() ?>
                            <!-- FIX: Asegúrate de que el campo oculto se llame 'id' y el valor sea 'id' o 'id_libro' según tu BD -->
                            <input type="hidden" name="id" value="<?= $libro['id_libro'] ?? $libro['id'] ?>"> 
                            
                            <div class="row g-2 mb-2">
                                <div class="col-7">
                                    <select name="formato" class="form-select form-select-sm">
                                        <!-- FIX: Estos options deben coincidir con los de tu tabla y validaciones -->
                                        <option value="Rústico">Rústico</option>
                                        <option value="Pasta Dura">Pasta Dura</option>
                                        <option value="Digital">Digital PDF</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input type="number" name="cantidad" min="1" max="<?= $libro['stock'] ?>" value="1" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            
                            <!-- Botón dinámico según stock -->
                            <?php if($libro['stock'] > 0): ?>
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-cart-plus"></i> Agregar
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary btn-sm w-100" disabled>Agotado</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <?php if (isset($pager)): ?>
            <div class="d-flex justify-content-center">
                <!-- Se asume que has configurado la plantilla 'default_full' para usar clases de Bootstrap -->
                <?= $pager->links('default', 'default_full') ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Script para alternar los inputs de búsqueda según el filtro seleccionado -->
    <script>
        document.getElementById('tipoFiltro').addEventListener('change', function() {
            const isTitulo = this.value === 'titulo';
            
            document.getElementById('filtro-titulo').classList.toggle('filtro-activo', isTitulo);
            document.getElementById('filtro-autor').classList.toggle('filtro-activo', !isTitulo);
            
            // Deshabilitamos los inputs ocultos para que no viajen en la URL innecesariamente (limpieza de URL GET)
            document.querySelector('#filtro-titulo input').disabled = !isTitulo;
            document.querySelectorAll('#filtro-autor input').forEach(inp => inp.disabled = isTitulo);
        });
        
        // Ejecutar al cargar la página para establecer el estado inicial
        document.getElementById('tipoFiltro').dispatchEvent(new Event('change'));
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
/** @var array $autores */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Registrar Libro</h4>
                </div>
                <div class="card-body">

                    <!-- Mensajes Generales -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success">
                            <?= esc(session()->getFlashdata('exito')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Lista de Errores de Validación -->
                    <?php if (session()->has('errores')): ?>
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                <?php foreach (session('errores') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('Administrador/Libro/guardar') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Título:</label>
                                <input type="text" name="titulo" 
                                       class="form-control <?= session('errores.titulo') ? 'is-invalid' : '' ?>" 
                                       value="<?= old('titulo') ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">ISBN:</label>
                                <input type="text" name="isbn" 
                                       class="form-control <?= session('errores.isbn') ? 'is-invalid' : '' ?>" 
                                       value="<?= old('isbn') ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Formato:</label>
                                <select name="formato" class="form-select <?= session('errores.formato') ? 'is-invalid' : '' ?>" required>
                                    <option value="">Selecciona uno...</option>
                                    <option value="pasta dura" <?= old('formato') == 'pasta dura' ? 'selected' : '' ?>>Pasta dura</option>
                                    <option value="rustico" <?= old('formato') == 'rustico' ? 'selected' : '' ?>>Rústico</option>
                                    <option value="digital" <?= old('formato') == 'digital' ? 'selected' : '' ?>>Digital</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Precio:</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" name="precio" 
                                           class="form-control <?= session('errores.precio') ? 'is-invalid' : '' ?>" 
                                           value="<?= old('precio') ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stock:</label>
                                <input type="number" min="0" name="stock" 
                                       class="form-control <?= session('errores.stock') ? 'is-invalid' : '' ?>" 
                                       value="<?= old('stock') ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Autores (Selecciona al menos uno):</label>
                            <div class="card p-3 <?= session('errores.autores') ? 'border-danger' : 'border-light' ?> bg-light">
                                <?php if (empty($autores)): ?>
                                    <p class="mb-0 text-muted">
                                        No hay autores registrados todavía.
                                        <a href="<?= site_url('Administrador/Autor/crear') ?>">Crea uno primero</a>.
                                    </p>
                                <?php else: ?>
                                    <div class="row">
                                        <?php 
                                        // Recuperamos los autores que el usuario había marcado en caso de error
                                        $autoresMarcados = old('autores', []); 
                                        ?>
                                        <?php foreach ($autores as $autor): ?>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <!-- Nota: Cambié $autor['id_autor'] por $autor['id'] basado en el Modelo que creamos -->
                                                    <input class="form-check-input" type="checkbox" name="autores[]" 
                                                           value="<?= $autor['id'] ?>" 
                                                           id="autor_<?= $autor['id'] ?>"
                                                           <?= in_array($autor['id'], $autoresMarcados) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="autor_<?= $autor['id'] ?>">
                                                        <?= esc($autor['nombre'] . ' ' . $autor['apellidos']) ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if(session('errores.autores')): ?>
                                <div class="text-danger small mt-1">Debes seleccionar al menos un autor.</div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Guardar Libro</button>
                            <a href="<?= site_url('Administrador/Libro') ?>" class="btn btn-outline-secondary">Cancelar y Volver</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
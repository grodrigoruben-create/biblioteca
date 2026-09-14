<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Autor</title>
</head>
<body>
    <h2>Registrar Autor</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('exito')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('exito')) ?></p>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div style="color:red;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('Administrador/Autor/guardar') ?>" method="post">
        <?= csrf_field() ?>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= old('nombre') ?>" required><br><br>

        <label>Apellidos:</label><br>
        <input type="text" name="apellidos" value="<?= old('apellidos') ?>" required><br><br>

        <label>Nacionalidad:</label><br>
        <input type="text" name="nacionalidad" value="<?= old('nacionalidad') ?>"><br><br>

        <button type="submit">Guardar Autor</button>
    </form>

    <p><a href="<?= site_url('dashboard') ?>">Volver al panel</a></p>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Autor</title>
    <!-- Agregamos Bootstrap para estilizar rápidamente -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrar Autor</h4>
                </div>
                <div class="card-body">

                    <!-- Mensaje de Error General -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Mensaje de Éxito -->
                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success">
                            <?= esc(session()->getFlashdata('exito')) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Lista de Errores de Validación del Modelo -->
                    <?php if (session()->has('errores')): ?>
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                <?php foreach (session('errores') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario -->
                    <form action="<?= site_url('Administrador/Autor/guardar') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Nombre:</label>
                            <!-- Agregamos clase is-invalid si hay un error específico en 'nombre' -->
                            <input type="text" name="nombre" 
                                   class="form-control <?= session('errores.nombre') ? 'is-invalid' : '' ?>" 
                                   value="<?= old('nombre') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellidos:</label>
                            <input type="text" name="apellidos" 
                                   class="form-control <?= session('errores.apellidos') ? 'is-invalid' : '' ?>" 
                                   value="<?= old('apellidos') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Nacionalidad:</label>
                            <input type="text" name="nacionalidad" 
                                   class="form-control <?= session('errores.nacionalidad') ? 'is-invalid' : '' ?>" 
                                   value="<?= old('nacionalidad') ?>">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar Autor</button>
                            <a href="<?= site_url('Administrador/Autor') ?>" class="btn btn-outline-secondary">Cancelar y Volver</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
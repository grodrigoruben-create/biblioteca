<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; }
        .login-card { max-width: 420px; border: none; border-radius: 12px; box-shadow: 0 10px 25px 
rgba(0,0,0,0.08); }
    </style>
    
</head>
<body class="d-flex align-items-center min-vh-100 py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card p-4 mx-auto">
                <div class="card-body">

                    <h3 class="text-center fw-bold text-primary mb-4">Iniciar Sesión</h3>

                    <?php if(session()->getFlashdata('msg_error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('msg_error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('msg_success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('msg_success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/login') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" 
placeholder="correo@ejemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" 
placeholder="••••••••" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fs-6">Entrar</button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-2 text-muted small">¿Aún no tienes una cuenta?</p>

                        <button type="button" class="btn btn-outline-success w-100" 
data-bs-toggle="modal" data-bs-target="#modalRegistro">
                            Crear cuenta de Cliente
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EMERGENTE DE REGISTRO -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-3">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title fw-bold" id="modalRegistroLabel">
                    Registro de Nuevo Cliente
                </h5>

                <button type="button" class="btn-close btn-close-white" 
data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <form action="<?= base_url('/register') ?>" method="post">

                <?= csrf_field() ?>

                <div class="modal-body p-4">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="reg_nombre" class="form-label">Nombre(s)</label>
                            <input type="text" name="nombre" id="reg_nombre" class="form-control" 
required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="reg_apellidos" class="form-label">Apellidos</label>
                            <input type="text" name="apellidos" id="reg_apellidos" class="form-control" 
required>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label for="reg_email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="reg_email" class="form-control" 
placeholder="nombre@ejemplo.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="reg_password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="reg_password" class="form-control" 
minlength="6" required>
                    </div>

                </div>

                <div class="modal-footer bg-light">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-success">
                        Registrarme
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<!-- JS de Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if(session()->getFlashdata('open_modal')): ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modalRegistro = new bootstrap.Modal(document.getElementById('modalRegistro'));
        modalRegistro.show();
    });
</script>

<?php endif; ?>

</body>
</html>

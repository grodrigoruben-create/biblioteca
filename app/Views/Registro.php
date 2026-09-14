<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Librería Universitaria</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-sm-5">
                    
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-dark">Crear Cuenta</h2>
                        <p class="text-muted small">Regístrate para comenzar a comprar en la librería</p>
                    </div>

                    <!-- Mensajes de Error o Éxito Generales -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('exito')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= esc(session()->getFlashdata('exito')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Errores de Validación -->
                    <?php if ($validation = session('validation')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?= $validation->listErrors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario -->
                    <form action="<?= base_url('registro') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?= old('apellidos') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" placeholder="correo@universidad.edu" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña:</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Mínimo 8 caracteres" required minlength="8">
                                <button class="btn btn-outline-secondary" type="button" id="show-btn">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="d-grid">
                                <button type="button" id="generate-btn" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-magic"></i> Generar Contraseña Fuerte
                                </button>
                            </div>
                            <div class="form-text text-muted small mt-1">
                                Debe incluir mayúsculas, minúsculas, números y un carácter especial (@$!%*?&).
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">Registrarme</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">¿Ya tienes cuenta?</p>
                        <a href="<?= base_url('login') ?>" class="text-decoration-none fw-bold">Inicia sesión aquí</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Generador de contraseña fuerte ajustado al regex del backend
    document.getElementById('generate-btn').addEventListener('click', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        passwordInput.value = generateStrongPassword(12);
        // Cambiar temporalmente a texto para que el usuario vea la contraseña generada
        passwordInput.type = 'text';
        document.getElementById('show-btn').innerHTML = '<i class="bi bi-eye-slash"></i>';
    });

    function generateStrongPassword(length = 12) {
        const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const specialChars = '@$!%*?&'; 

        let password = '';
        password += uppercase[Math.floor(Math.random() * uppercase.length)];
        password += lowercase[Math.floor(Math.random() * lowercase.length)];
        password += numbers[Math.floor(Math.random() * numbers.length)];
        password += specialChars[Math.floor(Math.random() * specialChars.length)];

        const allChars = uppercase + lowercase + numbers + specialChars;
        for (let i = password.length; i < length; i++) {
            password += allChars[Math.floor(Math.random() * allChars.length)];
        }
        return password.split('').sort(() => 0.5 - Math.random()).join(''); 
    }

    // Botón para mostrar / ocultar contraseña
    document.getElementById('show-btn').addEventListener('click', function() {
        const passwordInput = document.querySelector('input[name="password"]');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            this.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
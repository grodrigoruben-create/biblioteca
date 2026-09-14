<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Crear Cuenta</h2>

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

    <!-- action apunta a la ruta real de registro (POST /registro) -->
    <form action="<?= base_url('registro') ?>" method="post">
        <?= csrf_field() ?>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= old('nombre') ?>" required><br><br>

        <label>Apellidos:</label><br>
        <input type="text" name="apellidos" value="<?= old('apellidos') ?>" required><br><br>

        <!-- antes: name="gmail", pero el controller espera 'email' -->
        <label>Correo:</label><br>
        <input type="email" name="email" value="<?= old('email') ?>" required><br><br>

        <!-- antes: name="contrasena", pero el controller espera 'password' -->
        <label>Contraseña:</label><br>
        <input type="password" name="password" id="password" required minlength="8">

        <button type="button" id="show-btn">
            Mostrar contraseña
        </button>

        <button type="button" id="generate-btn">Generar Contraseña Fuerte</button><br><br>

        <button type="submit">Registrarme</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="<?= base_url('login') ?>">Inicia sesión aquí</a></p>
</body>
<script>
    document.getElementById('generate-btn').addEventListener('click', function() {
        const passwordInput = document.getElementsByName('password')[0];
        passwordInput.value = generateStrongPassword(12);
    });

    function generateStrongPassword(length = 12) {
        const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const specialChars = '@$!%*?&'; // FIX: antes incluía símbolos (#, /, (, ), =, ¡, ¿, etc.) que el regex del backend no permite, por eso fallaba la validación

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
    document.getElementById('generate-btn').addEventListener('click', function() {
    const passwordInput = document.querySelector('input[name="password"]');

    passwordInput.value = generateStrongPassword(12);
    });

    document.getElementById('show-btn').addEventListener('click', function() {
        const passwordInput = document.querySelector('input[name="password"]');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.textContent = 'Ocultar contraseña';
        } else {
            passwordInput.type = 'password';
            this.textContent = 'Mostrar contraseña';
        }
    });
</script>
</html>
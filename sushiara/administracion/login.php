<?php

declare(strict_types=1);

require __DIR__ . '/seguridad.php';
require __DIR__ . '/../incluye/bd.php';

// Si ya existe sesion iniciada, no mostramos login otra vez.
if (admin_autenticado()) {
    header('Location: pedidos.php');
    exit;
}

$error = '';

// Cuando el formulario se envia, comprobamos usuario y contrasena.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim((string) ($_POST['usuario'] ?? ''));
    $clave = trim((string) ($_POST['clave'] ?? ''));

    // Buscamos el administrador en base de datos por nombre de usuario.
    $statement = $pdo->prepare('SELECT id, usuario, clave_hash FROM administradores WHERE usuario = ? LIMIT 1');
    $statement->execute([$usuario]);
    $admin = $statement->fetch();

    // password_verify compara la contrasena escrita con el hash guardado.
    if ($admin && password_verify($clave, $admin['clave_hash'])) {
        $_SESSION['admin_autenticado'] = true;
        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_usuario'] = $admin['usuario'];
        header('Location: pedidos.php');
        exit;
    }

    $error = 'Usuario o contrasena incorrectos.';
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shushiara</title>
    <link rel="icon" type="image/svg+xml" href="../recursos/imagenes/logo-shushiara.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/css/estilos.css">
</head>
<body class="pagina-simple login-page">
    <!-- Pantalla centrada de acceso interno. -->
    <main class="login-admin">
        <div class="login-panel">
            <img class="login-logo" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara">
            <p class="subtitulo mt-4">Acceso interno</p>
            <h1>Administracion</h1>
            <!-- Formulario clasico POST porque el login no necesita JavaScript. -->
            <form method="post" class="mt-4">
                <div class="mb-3">
                    <label class="form-label" for="usuario">Usuario</label>
                    <input class="form-control" id="usuario" name="usuario" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="clave">Contrasena</label>
                    <input class="form-control" id="clave" type="password" name="clave" required>
                </div>
                <button class="btn btn-sushi w-100" type="submit">Entrar</button>
                <?php if ($error !== ''): ?>
                    <p class="form-message error mt-3"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
            </form>
            <a class="btn btn-outline-dark w-100 mt-3 login-volver" href="../index.php">Volver a la web</a>
        </div>
    </main>
</body>
</html>

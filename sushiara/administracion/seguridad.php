<?php

declare(strict_types=1);

// Inicia la sesion para recordar si el administrador ya inicio sesion.
session_start();

// Comprueba si la sesion actual pertenece a un administrador autenticado.
function admin_autenticado(): bool
{
    return isset($_SESSION['admin_autenticado']) && $_SESSION['admin_autenticado'] === true;
}

// Protege una pagina: si no hay login, redirige a login.php.
function exigir_admin(): void
{
    if (!admin_autenticado()) {
        header('Location: login.php');
        exit;
    }
}

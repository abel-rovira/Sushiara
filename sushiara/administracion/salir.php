<?php

declare(strict_types=1);

require __DIR__ . '/seguridad.php';

// Vaciamos todas las variables de sesion del administrador.
$_SESSION = [];

// Destruimos la sesion para cerrar el acceso interno.
session_destroy();

// Volvemos al login despues de cerrar sesion.
header('Location: login.php');
exit;

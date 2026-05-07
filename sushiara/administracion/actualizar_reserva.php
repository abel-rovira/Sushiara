<?php

declare(strict_types=1);

require __DIR__ . '/seguridad.php';
require __DIR__ . '/../incluye/bd.php';

// Solo administradores con sesion pueden cambiar estados.
exigir_admin();

// Solo aceptamos POST porque este archivo modifica datos.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservas.php');
    exit;
}

$reservaId = (int) ($_POST['reserva_id'] ?? 0);
$estado = trim((string) ($_POST['estado'] ?? ''));

// Estados permitidos segun el ENUM de la tabla reservas.
$estadosPermitidos = ['pendiente', 'confirmada', 'cancelada'];

if ($reservaId > 0 && in_array($estado, $estadosPermitidos, true)) {
    $statement = $pdo->prepare('UPDATE reservas SET estado = ? WHERE id = ?');
    $statement->execute([$estado, $reservaId]);
}

header('Location: reservas.php');
exit;


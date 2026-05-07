<?php

declare(strict_types=1);

require __DIR__ . '/seguridad.php';
require __DIR__ . '/../incluye/bd.php';

// Solo administradores con sesion pueden cambiar estados.
exigir_admin();

// Solo aceptamos POST porque este archivo modifica datos.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pedidos.php');
    exit;
}

$pedidoId = (int) ($_POST['pedido_id'] ?? 0);
$estado = trim((string) ($_POST['estado'] ?? ''));

// Estados permitidos segun el ENUM de la tabla pedidos.
$estadosPermitidos = ['pendiente', 'preparando', 'listo', 'enviado', 'entregado', 'cancelado'];

if ($pedidoId > 0 && in_array($estado, $estadosPermitidos, true)) {
    $statement = $pdo->prepare('UPDATE pedidos SET estado = ? WHERE id = ?');
    $statement->execute([$estado, $pedidoId]);
}

header('Location: pedidos.php');
exit;


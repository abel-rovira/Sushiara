<?php

declare(strict_types=1);

require __DIR__ . '/../incluye/bd.php';
require __DIR__ . '/seguridad.php';

// Impide entrar al panel si no se ha iniciado sesion.
exigir_admin();

// Cargamos reservas ordenadas por fecha y hora.
$reservas = $pdo
    ->query('SELECT * FROM reservas ORDER BY fecha_reserva DESC, hora_reserva DESC')
    ->fetchAll();

$pendientes = count(array_filter($reservas, static fn (array $reserva): bool => $reserva['estado'] === 'pendiente'));
$personasTotales = array_sum(array_map(static fn (array $reserva): int => (int) $reserva['personas'], $reservas));
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
<body class="pagina-simple admin-page">
    <!-- Navegacion interna del panel de reservas. -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-superior">
        <div class="container-xxl">
            <a class="navbar-brand marca" href="../index.php"><img class="logo-nav" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara"></a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="../index.php">Inicio</a>
                <a class="btn btn-outline-light" href="../paginas/reservar.php">Reservar</a>
                <a class="btn btn-sushi" href="pedidos.php">Pedidos</a>
                <a class="btn btn-outline-light" href="salir.php">Salir</a>
            </div>
        </div>
    </nav>

    <!-- Cabecera visual del panel de reservas. -->
    <header class="cabecera-admin">
        <div class="container-xxl">
            <p class="subtitulo">Panel interno</p>
            <h1>Administracion de reservas</h1>
            <p>Consulta las mesas reservadas, horarios, personas y estado de confirmacion.</p>
        </div>
    </header>

    <main class="py-5">
        <div class="container-xxl">
            <!-- Metricas principales de reservas. -->
            <div class="row g-3 mb-4">
                <div class="col-md-4"><div class="admin-metrica"><span>Total reservas</span><strong><?= count($reservas) ?></strong></div></div>
                <div class="col-md-4"><div class="admin-metrica"><span>Pendientes</span><strong><?= $pendientes ?></strong></div></div>
                <div class="col-md-4"><div class="admin-metrica"><span>Personas</span><strong><?= $personasTotales ?></strong></div></div>
            </div>

            <div class="admin-card p-0 table-responsive">
                <table class="items-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Telefono</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Personas</th>
                            <th>Zona</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservas as $reserva): ?>
                            <tr>
                                <td><?= (int) $reserva['id'] ?></td>
                                <td><?= htmlspecialchars($reserva['nombre_cliente']) ?></td>
                                <td><?= htmlspecialchars($reserva['telefono_cliente']) ?></td>
                                <td><?= htmlspecialchars($reserva['fecha_reserva']) ?></td>
                                <td><?= htmlspecialchars($reserva['hora_reserva']) ?></td>
                                <td><?= (int) $reserva['personas'] ?></td>
                                <td><?= htmlspecialchars($reserva['zona']) ?></td>
                                <td>
                                    <!-- Formulario pequeno para cambiar el estado de una reserva. -->
                                    <form class="admin-tabla-form" action="actualizar_reserva.php" method="post">
                                        <input type="hidden" name="reserva_id" value="<?= (int) $reserva['id'] ?>">
                                        <select class="form-select" name="estado">
                                            <?php foreach (['pendiente', 'confirmada', 'cancelada'] as $estado): ?>
                                                <option value="<?= $estado ?>" <?= $reserva['estado'] === $estado ? 'selected' : '' ?>>
                                                    <?= ucfirst($estado) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-sushi btn-sm" type="submit">OK</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($reservas) === 0): ?>
                            <tr><td colspan="8">Todavia no hay reservas.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>

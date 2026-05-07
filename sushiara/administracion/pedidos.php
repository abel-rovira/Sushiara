<?php

declare(strict_types=1);

require __DIR__ . '/../incluye/bd.php';
require __DIR__ . '/../incluye/funciones.php';
require __DIR__ . '/seguridad.php';

// Impide entrar al panel si no se ha iniciado sesion.
exigir_admin();

// Cargamos todos los pedidos, del mas reciente al mas antiguo.
$pedidos = $pdo
    ->query('SELECT * FROM pedidos ORDER BY creado_en DESC')
    ->fetchAll();

$totalFacturado = array_sum(array_map(static fn (array $pedido): float => (float) $pedido['total'], $pedidos));
$pendientes = count(array_filter($pedidos, static fn (array $pedido): bool => $pedido['estado'] === 'pendiente'));

// Esta consulta se reutiliza para obtener los productos de cada pedido.
$itemsStatement = $pdo->prepare('SELECT * FROM detalles_pedido WHERE pedido_id = ? ORDER BY id');
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
    <!-- Navegacion interna del panel de pedidos. -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-superior">
        <div class="container-xxl">
            <a class="navbar-brand marca" href="../index.php"><img class="logo-nav" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara"></a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="../index.php">Inicio</a>
                <a class="btn btn-outline-light" href="../paginas/pedido.php">Carta</a>
                <a class="btn btn-sushi" href="reservas.php">Reservas</a>
                <a class="btn btn-outline-light" href="salir.php">Salir</a>
            </div>
        </div>
    </nav>

    <!-- Cabecera visual del panel de administracion. -->
    <header class="cabecera-admin">
        <div class="container-xxl">
            <p class="subtitulo">Panel interno</p>
            <h1>Administracion de pedidos</h1>
            <p>Control rapido de pedidos recibidos, clientes, importes y productos vendidos.</p>
        </div>
    </header>

    <main class="py-5">
        <div class="container-xxl">
            <!-- Metricas rapidas para saber el estado del negocio. -->
            <div class="row g-3 mb-4">
                <div class="col-md-4"><div class="admin-metrica"><span>Total pedidos</span><strong><?= count($pedidos) ?></strong></div></div>
                <div class="col-md-4"><div class="admin-metrica"><span>Pendientes</span><strong><?= $pendientes ?></strong></div></div>
                <div class="col-md-4"><div class="admin-metrica"><span>Facturado</span><strong><?= dinero($totalFacturado) ?></strong></div></div>
            </div>

            <?php if (count($pedidos) === 0): ?>
                <div class="bloque-cuadrado p-4">Todavia no hay pedidos.</div>
            <?php endif; ?>

            <div class="d-grid gap-3">
                <?php foreach ($pedidos as $pedido): ?>
                    <?php
                    // Para cada pedido buscamos sus productos.
                    $itemsStatement->execute([(int) $pedido['id']]);
                    $items = $itemsStatement->fetchAll();
                    ?>
                    <article class="admin-card">
                        <div class="admin-card-header">
                            <div>
                                <span class="badge estado-abierto">Pedido #<?= (int) $pedido['id'] ?></span>
                                <h2><?= htmlspecialchars($pedido['nombre_cliente']) ?></h2>
                            </div>
                            <div class="text-lg-end">
                                <strong><?= dinero((float) $pedido['total']) ?></strong>
                                <span><?= htmlspecialchars($pedido['estado']) ?></span>
                            </div>
                        </div>

                        <!-- Formulario para cambiar el estado del pedido desde administracion. -->
                        <form class="admin-estado-form" action="actualizar_pedido.php" method="post">
                            <input type="hidden" name="pedido_id" value="<?= (int) $pedido['id'] ?>">
                            <label for="estado_pedido_<?= (int) $pedido['id'] ?>">Cambiar estado</label>
                            <select class="form-select" id="estado_pedido_<?= (int) $pedido['id'] ?>" name="estado">
                                <?php foreach (['pendiente', 'preparando', 'listo', 'enviado', 'entregado', 'cancelado'] as $estado): ?>
                                    <option value="<?= $estado ?>" <?= $pedido['estado'] === $estado ? 'selected' : '' ?>>
                                        <?= ucfirst($estado) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-sushi" type="submit">Guardar</button>
                        </form>

                        <dl class="order-meta">
                            <div><dt>Telefono</dt><dd><?= htmlspecialchars($pedido['telefono_cliente']) ?></dd></div>
                            <div><dt>Direccion</dt><dd><?= htmlspecialchars($pedido['direccion_cliente']) ?></dd></div>
                            <div><dt>Entrega</dt><dd><?= htmlspecialchars($pedido['tipo_entrega']) ?></dd></div>
                            <div><dt>Pago</dt><dd><?= htmlspecialchars($pedido['metodo_pago']) ?></dd></div>
                            <div><dt>Referencia pago</dt><dd><?= htmlspecialchars((string) ($pedido['referencia_pago'] ?? 'Pago simulado')) ?></dd></div>
                            <div><dt>Fecha</dt><dd><?= htmlspecialchars((string) $pedido['fecha_entrega']) ?></dd></div>
                            <div><dt>Hora</dt><dd><?= htmlspecialchars((string) $pedido['hora_entrega']) ?></dd></div>
                            <div><dt>Creado</dt><dd><?= htmlspecialchars($pedido['creado_en']) ?></dd></div>
                        </dl>

                        <?php if ((string) $pedido['notas'] !== ''): ?>
                            <p class="admin-nota"><?= nl2br(htmlspecialchars($pedido['notas'])) ?></p>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                                            <td><?= (int) $item['cantidad'] ?></td>
                                            <td><?= dinero((float) $item['precio_unitario']) ?></td>
                                            <td><?= dinero((float) $item['subtotal']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>
</html>

<?php

declare(strict_types=1);

require __DIR__ . '/../incluye/bd.php';

// Orden en el que queremos mostrar las categorias dentro de la carta.
$ordenCategorias = [
    'Promociones',
    'Combos',
    'Entrantes',
    'Rolls Clasicos',
    'Rolls Especiales',
    'Nigiris',
    'Sashimi',
    'Ramen y Sopas',
    'Wok y Noodles',
    'Gohan',
    'Postres',
    'Bebidas',
];

$productos = $pdo
    ->query("SELECT id, nombre, descripcion, categoria, precio, imagen, etiqueta, picante FROM productos WHERE activo = 1 ORDER BY FIELD(categoria, 'Promociones','Combos','Entrantes','Rolls Clasicos','Rolls Especiales','Nigiris','Sashimi','Ramen y Sopas','Wok y Noodles','Gohan','Postres','Bebidas'), nombre")
    ->fetchAll();

// Agrupamos productos por categoria para poder imprimir secciones completas.
$productosPorCategoria = [];

foreach ($productos as $producto) {
    $productosPorCategoria[$producto['categoria']][] = $producto;
}

$categorias = array_values(array_filter($ordenCategorias, static fn (string $categoria): bool => isset($productosPorCategoria[$categoria])));
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
<body class="pagina-simple">
    <!-- Navegacion de la pagina de pedido. -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-superior">
        <div class="container-xxl">
            <a class="navbar-brand marca" href="../index.php"><img class="logo-nav" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara"></a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="../index.php">Inicio</a>
                <a class="btn btn-sushi" href="reservar.php">Reservar</a>
            </div>
        </div>
    </nav>

    <!-- Cabecera visual con resumen de entrega y valoracion. -->
    <header class="cabecera-pedido">
        <div class="container-xxl">
            <div class="row g-4 align-items-end">
                <div class="col-lg-7">
                    <p class="subtitulo">Carta online</p>
                    <h1>Pedido a domicilio</h1>
                    <p>Elige sushi, ramen, sopas, noodles, postres y bebidas. Cocina japonesa preparada al momento.</p>
                </div>
                <div class="col-lg-5">
                    <div class="pedido-datos">
                        <div><span>Entrega</span><strong>30-45 min</strong></div>
                        <div><span>Minimo</span><strong>12,00 EUR</strong></div>
                        <div><span>Valoracion</span><strong>4,8/5</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido principal: categorias, listado de productos y carrito. -->
    <main class="py-5" id="carta">
        <div class="container-xxl">
            <div class="row g-4 align-items-start">
                <aside class="col-lg-2">
                    <!-- Menu lateral de categorias. -->
                    <div class="categorias-sticky">
                        <p class="titulo-lateral">Categorias</p>
                        <div class="nav categorias-menu flex-lg-column gap-2">
                            <button class="categoria-btn active" type="button" data-category="all">Todo</button>
                            <?php foreach ($categorias as $categoria): ?>
                                <button class="categoria-btn" type="button" data-category="<?= htmlspecialchars($categoria) ?>"><?= htmlspecialchars($categoria) ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </aside>

                <section class="col-lg-7">
                    <!-- Listado de productos agrupados por categoria. -->
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                        <div>
                            <p class="subtitulo mb-1">Menu completo</p>
                            <h2 class="mb-0">Nuestra carta</h2>
                        </div>
                        <div class="buscador-carta">
                            <input class="form-control" id="buscadorProductos" type="search" placeholder="Buscar sushi, combo, bebida...">
                        </div>
                    </div>

                    <?php foreach ($categorias as $categoria): ?>
                        <div class="grupo-categoria" data-category-group="<?= htmlspecialchars($categoria) ?>">
                            <div class="encabezado-categoria">
                                <h3><?= htmlspecialchars($categoria) ?></h3>
                                <span><?= count($productosPorCategoria[$categoria]) ?> productos</span>
                            </div>
                            <div class="lista-productos">
                                <?php foreach ($productosPorCategoria[$categoria] as $producto): ?>
                                    <!-- Cada producto lleva data-* para que JavaScript pueda filtrar y anadir al carrito. -->
                                    <article class="producto-linea" data-category="<?= htmlspecialchars($producto['categoria']) ?>" data-search="<?= htmlspecialchars(strtolower($producto['nombre'] . ' ' . $producto['descripcion'] . ' ' . $producto['categoria'])) ?>">
                                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="">
                                        <div class="producto-cuerpo">
                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                <h4><?= htmlspecialchars($producto['nombre']) ?></h4>
                                                <?php if ($producto['etiqueta']): ?><span class="badge badge-sushi"><?= htmlspecialchars($producto['etiqueta']) ?></span><?php endif; ?>
                                                <?php if ((int) $producto['picante'] === 1): ?><span class="badge text-bg-danger">Picante</span><?php endif; ?>
                                            </div>
                                            <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                                            <div class="d-flex align-items-center justify-content-between gap-3">
                                                <strong><?= number_format((float) $producto['precio'], 2, ',', '.') ?> EUR</strong>
                                                <button class="btn btn-outline-sushi add-btn" type="button" data-id="<?= (int) $producto['id'] ?>" data-name="<?= htmlspecialchars($producto['nombre']) ?>" data-price="<?= htmlspecialchars((string) $producto['precio']) ?>">Anadir</button>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>

                <aside class="col-lg-3" id="pedido">
                    <!-- Carrito y formulario final de pedido. -->
                    <div class="pedido-sticky">
                        <div class="pedido-panel">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div><p class="subtitulo mb-1">Tu carrito</p><h2 class="h4 mb-0">Pedido</h2></div>
                                <span class="contador-carrito" id="cartCount">0</span>
                            </div>
                            <div class="cart-items" id="cartItems"><p class="empty-cart">El carrito esta vacio.</p></div>
                            <div class="resumen-precio mt-3">
                                <div><span>Subtotal</span><strong id="cartSubtotal">0,00 EUR</strong></div>
                                <div><span>Envio</span><strong id="cartDelivery">0,00 EUR</strong></div>
                                <div class="total"><span>Total</span><strong id="cartTotal">0,00 EUR</strong></div>
                            </div>
                        </div>

                        <form class="pedido-panel mt-3" id="orderForm">
                            <p class="subtitulo mb-1">Datos de entrega</p>
                            <h2 class="h4 mb-3">Finalizar</h2>
                            <div class="btn-group w-100 mb-3" role="group" aria-label="Tipo de entrega">
                                <input class="btn-check" type="radio" name="tipo_entrega" id="domicilio" value="domicilio" checked>
                                <label class="btn btn-outline-dark" for="domicilio">Domicilio</label>
                                <input class="btn-check" type="radio" name="tipo_entrega" id="recogida" value="recogida">
                                <label class="btn btn-outline-dark" for="recogida">Recogida</label>
                            </div>
                            <div class="mb-3"><label class="form-label" for="nombre_cliente">Nombre</label><input class="form-control" id="nombre_cliente" type="text" name="nombre_cliente" required maxlength="120"></div>
                            <div class="mb-3"><label class="form-label" for="telefono_cliente">Telefono</label><input class="form-control" id="telefono_cliente" type="tel" name="telefono_cliente" required maxlength="30"></div>
                            <div class="mb-3"><label class="form-label" for="direccion_cliente">Direccion</label><input class="form-control" id="direccion_cliente" type="text" name="direccion_cliente" required maxlength="255"></div>
                            <div class="row g-2">
                                <div class="col-6"><label class="form-label" for="fecha_entrega">Fecha</label><input class="form-control" id="fecha_entrega" type="date" name="fecha_entrega"></div>
                                <div class="col-6">
                                    <label class="form-label" for="hora_entrega">Hora</label>
                                    <select class="form-select" id="hora_entrega" name="hora_entrega" required>
                                        <option value="">Selecciona hora</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="14:30">14:30</option>
                                        <option value="15:00">15:00</option>
                                        <option value="15:30">15:30</option>
                                        <option value="16:00">16:00</option>
                                        <option value="16:30">16:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                        <option value="22:30">22:30</option>
                                        <option value="23:00">23:00</option>
                                        <option value="23:30">23:30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="my-3">
                                <label class="form-label" for="metodo_pago">Pago</label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago">
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="bizum">Bizum</option>
                                    <option value="efectivo">Efectivo</option>
                                </select>
                            </div>
                            <div class="pago-simulado mb-3">
                                <span>Pago simulado</span>
                                <strong>No se realiza ningun cargo real.</strong>
                            </div>
                            <div class="pago-opcion" data-pago="tarjeta">
                                <div class="mb-2">
                                    <label class="form-label" for="titular_tarjeta">Titular</label>
                                    <input class="form-control" id="titular_tarjeta" type="text" name="titular_tarjeta" maxlength="120" placeholder="Nombre de la tarjeta">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="numero_tarjeta">Numero de tarjeta</label>
                                    <input class="form-control" id="numero_tarjeta" type="text" name="numero_tarjeta" inputmode="numeric" maxlength="23" placeholder="4242 4242 4242 4242">
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <label class="form-label" for="caducidad_tarjeta">Caducidad</label>
                                        <input class="form-control" id="caducidad_tarjeta" type="text" name="caducidad_tarjeta" maxlength="5" placeholder="MM/AA">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="cvv_tarjeta">CVV</label>
                                        <input class="form-control" id="cvv_tarjeta" type="text" name="cvv_tarjeta" inputmode="numeric" maxlength="4" placeholder="123">
                                    </div>
                                </div>
                            </div>
                            <div class="pago-opcion" data-pago="bizum" hidden>
                                <div class="mb-3">
                                    <label class="form-label" for="telefono_bizum">Telefono Bizum</label>
                                    <input class="form-control" id="telefono_bizum" type="tel" name="telefono_bizum" maxlength="20" placeholder="600 123 456">
                                </div>
                            </div>
                            <div class="pago-opcion pago-aviso" data-pago="efectivo" hidden>
                                <strong>Pago en efectivo</strong>
                                <span>El pedido se paga al repartidor o en el local al recogerlo.</span>
                            </div>
                            <div class="mb-3"><label class="form-label" for="notas">Notas</label><textarea class="form-control" id="notas" name="notas" rows="3"></textarea></div>
                            <button class="btn btn-sushi w-100" type="submit">Enviar pedido</button>
                            <p class="form-message mt-3" id="formMessage" role="status"></p>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <!-- Footer publico reutilizado en paginas de cliente. -->
    <footer class="pie">
        <div class="container-xxl">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <img class="logo-footer" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara">
                    <p>
                        <span>Restaurante japones con sushi fresco.</span>
                        <span>Reservas en local y pedidos a domicilio.</span>
                    </p>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3>Menu</h3>
                    <a href="../index.php">Inicio</a>
                    <a href="../index.php#quienes-somos">Quienes somos</a>
                    <a href="pedido.php">Carta</a>
                    <a href="../index.php#horarios">Horarios</a>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3>Servicios</h3>
                    <a href="reservar.php">Reservar mesa</a>
                    <a href="pedido.php">Pedido a domicilio</a>
                    <a href="pedido.php">Recogida en local</a>
                </div>
                <div class="col-lg-3">
                    <h3>Contacto</h3>
                    <ul class="footer-lista">
                        <li>Carrer de la Mar 24, 46003 Valencia</li>
                        <li>600 123 456</li>
                        <li>ara@gmail.com</li>
                        <li>L-J: 13:00 - 16:00 / 20:00 - 23:30</li>
                        <li>V-S: 13:00 - 16:30 / 20:00 - 00:00</li>
                        <li>D: 13:00 - 16:00 / 20:00 - 23:00</li>
                    </ul>
                </div>
            </div>
            <div class="pie-inferior">
                <span>© 2026 Shushiara. Proyecto de pedidos y reservas.</span>
                <span>Sushi tradicional con alma moderna.</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../recursos/js/aplicacion.js"></script>
</body>
</html>

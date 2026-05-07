<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shushiara</title>
    <link rel="icon" type="image/svg+xml" href="recursos/imagenes/logo-shushiara.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="recursos/css/estilos.css">
</head>
<body class="inicio home-limpia">
    <!-- Navegacion principal publica. -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-superior fixed-top">
        <div class="container-xxl">
            <a class="navbar-brand marca" href="index.php">
                <img class="logo-nav" src="recursos/imagenes/logo-shushiara.svg" alt="Shushiara">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuSuperior" aria-controls="menuSuperior" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuSuperior">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#quienes-somos">Quienes somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="paginas/pedido.php">Carta</a></li>
                    <li class="nav-item"><a class="nav-link" href="paginas/pedido.php">Haz tu pedido</a></li>
                    <li class="nav-item"><a class="nav-link" href="paginas/reservar.php">Reserva</a></li>
                    <li class="nav-item"><a class="nav-link" href="#horarios">Horarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Portada principal con logo, titular y botones principales. -->
    <header class="portada" id="inicio">
        <div class="container-xxl">
            <div class="min-vh-portada d-flex align-items-center justify-content-center text-center">
                <div class="portada-contenido">
                    <img class="logo-hero" src="recursos/imagenes/logo-shushiara.svg" alt="Shushiara">
                    <p class="portada-superior">Sushi tradicional con alma moderna</p>
                    <h1><span>Fresh is</span><br>Boring</h1>
                    <p class="lead">La revolucion del sushi tradicional en Shushiara.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a class="btn btn-light btn-lg" href="paginas/reservar.php">Reservar mesa</a>
                        <a class="btn btn-outline-light btn-lg" href="paginas/pedido.php">Hacer pedido</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Seccion de presentacion del restaurante. -->
        <section class="seccion-editorial" id="quienes-somos">
            <div class="container-xxl">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <img class="imagen-editorial" src="https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?auto=format&fit=crop&w=1200&q=85" alt="Pescado fresco para sushi">
                    </div>
                    <div class="col-lg-6">
                        <p class="subtitulo">Quienes somos</p>
                        <h2>Pescado fresco, tecnica japonesa y una experiencia directa.</h2>
                        <p class="texto-editorial">Shushiara es un restaurante de sushi pensado para disfrutar en el local y tambien en casa. Preparamos arroz a diario, cortamos pescado fresco y trabajamos una carta clara: piezas tradicionales, rolls especiales, entrantes y combos para compartir.</p>
                        <p class="texto-editorial">Puedes reservar mesa para venir al local o realizar tu pedido a domicilio desde nuestra carta online.</p>
                        <div class="row g-3 mt-3">
                            <div class="col-sm-4"><div class="dato-editorial"><strong>4,8</strong><span>valoracion media</span></div></div>
                            <div class="col-sm-4"><div class="dato-editorial"><strong>30-45</strong><span>minutos entrega</span></div></div>
                            <div class="col-sm-4"><div class="dato-editorial"><strong>00:00</strong><span>viernes y sabado</span></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dos acciones principales: reservar mesa y hacer pedido. -->
        <section class="acciones-principales">
            <div class="container-xxl">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="accion-grande accion-reserva">
                            <div>
                                <p class="subtitulo">Mesa en local</p>
                                <h2>Reservar mesa</h2>
                                <p>Elige fecha, hora, personas y zona. Ideal para cenas, comidas y celebraciones.</p>
                            </div>
                            <a class="btn btn-light" href="paginas/reservar.php">Ir a reservas</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="accion-grande accion-pedido">
                            <div>
                                <p class="subtitulo">A domicilio</p>
                                <h2>Realizar pedido</h2>
                                <p>Abre la carta, anade productos al carrito y envia tu pedido directo a cocina.</p>
                            </div>
                            <a class="btn btn-sushi" href="paginas/pedido.php">Ir a pedidos</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Horarios visibles para clientes. -->
        <section class="py-5 horarios" id="horarios">
            <div class="container-xxl">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <p class="subtitulo">Horarios</p>
                        <h2>Abiertos todos los dias</h2>
                        <p class="texto-suave">Servicio en local, reservas de mesa, recogida y pedidos a domicilio.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="bloque-cuadrado p-4">
                            <div class="horario-linea"><span>Lunes a jueves</span><strong>13:00 - 16:00 / 20:00 - 23:30</strong></div>
                            <div class="horario-linea"><span>Viernes y sabado</span><strong>13:00 - 16:30 / 20:00 - 00:00</strong></div>
                            <div class="horario-linea"><span>Domingo</span><strong>13:00 - 16:00 / 20:00 - 23:00</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Resenas de clientes y valoracion media. -->
        <section class="py-5 reseñas">
            <div class="container-xxl">
                <div class="row g-4 align-items-end mb-4">
                    <div class="col-lg-7">
                        <p class="subtitulo">Opiniones</p>
                        <h2>Lo que dicen de Shushiara</h2>
                    </div>
                    <div class="col-lg-5">
                        <div class="puntuacion-global">
                            <strong>4,8/5</strong>
                            <span>★★★★★</span>
                            <p>Valoracion media de nuestros clientes</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="tarjeta-opinion">
                            <span class="estrellas">★★★★★</span>
                            <p>"Pescado fresco, arroz perfecto y un local muy cuidado. Se nota que trabajan con mimo."</p>
                            <strong>Laura G.</strong>
                            <small>Cena en local</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tarjeta-opinion destacada">
                            <span class="estrellas">★★★★★</span>
                            <p>"Reservar mesa fue facil y la cena salio perfecta. El servicio fue rapido y muy atento."</p>
                            <strong>Marcos R.</strong>
                            <small>Reserva de mesa</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="tarjeta-opinion">
                            <span class="estrellas">★★★★★</span>
                            <p>"El pedido llego caliente, bien presentado y los rolls estaban buenisimos. Repetimos seguro."</p>
                            <strong>Nerea M.</strong>
                            <small>Pedido a domicilio</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer publico de la web. -->
    <footer class="pie">
        <div class="container-xxl">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <img class="logo-footer" src="recursos/imagenes/logo-shushiara.svg" alt="Shushiara">
                    <p>
                        <span>Restaurante japones con sushi fresco.</span>
                        <span>Reservas en local y pedidos a domicilio.</span>
                    </p>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3>Menu</h3>
                    <a href="#inicio">Inicio</a>
                    <a href="#quienes-somos">Quienes somos</a>
                    <a href="paginas/pedido.php">Carta</a>
                    <a href="#horarios">Horarios</a>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3>Servicios</h3>
                    <a href="paginas/reservar.php">Reservar mesa</a>
                    <a href="paginas/pedido.php">Pedido a domicilio</a>
                    <a href="paginas/pedido.php">Recogida en local</a>
                    <a class="enlace-interno" href="administracion/login.php">Acceso interno</a>
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
</body>
</html>

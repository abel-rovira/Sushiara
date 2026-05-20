<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shushiara</title>
    <link rel="icon" type="image/svg+xml" href="recursos/imagenes/logo-shushiara.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="recursos/css/estilos.css?v=banderas-footer-3">
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
                    <li class="nav-item"><a class="nav-link" href="#inicio" data-i18n="inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#quienes-somos" data-i18n="quienesSomos">Quienes somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="paginas/pedido.php" data-i18n="carta">Carta</a></li>
                    <li class="nav-item"><a class="nav-link" href="paginas/pedido.php" data-i18n="hazPedido">Haz tu pedido</a></li>
                    <li class="nav-item"><a class="nav-link" href="paginas/reservar.php" data-i18n="reserva">Reserva</a></li>
                    <li class="nav-item"><a class="nav-link" href="#horarios" data-i18n="horarios">Horarios</a></li>
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
                    <p class="portada-superior" data-i18n="heroSuperior">Sushi tradicional con alma moderna</p>
                    <h1><span>Fresh is</span><br>Boring</h1>
                    <p class="lead" data-i18n="heroLead">La revolucion del sushi tradicional en Shushiara.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                        <a class="btn btn-light btn-lg" href="paginas/reservar.php" data-i18n="reservarMesa">Reservar mesa</a>
                        <a class="btn btn-outline-light btn-lg" href="paginas/pedido.php" data-i18n="hacerPedido">Hacer pedido</a>
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
                        <p class="subtitulo" data-i18n="quienesSub">Quienes somos</p>
                        <h2 data-i18n="quienesTitulo">Pescado fresco, tecnica japonesa y una experiencia directa.</h2>
                        <p class="texto-editorial" data-i18n="quienesTexto1">Shushiara es un restaurante de sushi pensado para disfrutar en el local y tambien en casa. Preparamos arroz a diario, cortamos pescado fresco y trabajamos una carta clara: piezas tradicionales, rolls especiales, entrantes y combos para compartir.</p>
                        <p class="texto-editorial" data-i18n="quienesTexto2">Puedes reservar mesa para venir al local o realizar tu pedido a domicilio desde nuestra carta online.</p>
                        <div class="row g-3 mt-3">
                            <div class="col-sm-4"><div class="dato-editorial"><strong>4,8</strong><span data-i18n="valoracionMedia">valoracion media</span></div></div>
                            <div class="col-sm-4"><div class="dato-editorial"><strong>30-45</strong><span data-i18n="minutosEntrega">minutos entrega</span></div></div>
                            <div class="col-sm-4"><div class="dato-editorial"><strong>00:00</strong><span data-i18n="viernesSabado">viernes y sabado</span></div></div>
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
                                <p class="subtitulo" data-i18n="mesaLocal">Mesa en local</p>
                                <h2 data-i18n="reservaTitulo">Reservar mesa</h2>
                                <p data-i18n="reservaTexto">Elige fecha, hora, personas y zona. Ideal para cenas, comidas y celebraciones.</p>
                            </div>
                            <a class="btn btn-light" href="paginas/reservar.php" data-i18n="irReservas">Ir a reservas</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="accion-grande accion-pedido">
                            <div>
                                <p class="subtitulo" data-i18n="domicilio">A domicilio</p>
                                <h2 data-i18n="pedidoTitulo">Realizar pedido</h2>
                                <p data-i18n="pedidoTexto">Abre la carta, anade productos al carrito y envia tu pedido directo a cocina.</p>
                            </div>
                            <a class="btn btn-sushi" href="paginas/pedido.php" data-i18n="irPedidos">Ir a pedidos</a>
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
                        <p class="subtitulo" data-i18n="horarios">Horarios</p>
                        <h2 data-i18n="abiertos">Abiertos todos los dias</h2>
                        <p class="texto-suave" data-i18n="horariosTexto">Servicio en local, reservas de mesa, recogida y pedidos a domicilio.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="bloque-cuadrado p-4">
                            <div class="horario-linea"><span data-i18n="lunesJueves">Lunes a jueves</span><strong>13:00 - 16:00 / 20:00 - 23:30</strong></div>
                            <div class="horario-linea"><span data-i18n="viernesSabadoDia">Viernes y sabado</span><strong>13:00 - 16:30 / 20:00 - 00:00</strong></div>
                            <div class="horario-linea"><span data-i18n="domingo">Domingo</span><strong>13:00 - 16:00 / 20:00 - 23:00</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mapa de ubicacion insertado en la web para que el cliente encuentre el restaurante. -->
        <section class="py-5 ubicacion" id="ubicacion">
            <div class="container-xxl">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-3">
                        <p class="subtitulo" data-i18n="ubicacion">Ubicacion</p>
                        <h2 data-i18n="ubicacionTitulo">Estamos en Valencia</h2>
                        <p class="texto-suave" data-i18n="ubicacionTexto">Encuentra Shushiara en Carrer de la Mar 24, 46003 Valencia. Puedes venir al local, recoger tu pedido o reservar mesa.</p>
                        <a class="btn btn-sushi" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query=Carrer%20de%20la%20Mar%2024%2C%2046003%20Valencia" data-i18n="abrirMapa">Abrir en Maps</a>
                    </div>
                    <div class="col-lg-9">
                        <div class="mapa-local">
                            <iframe class="mapa-iframe" title="Mapa de Shushiara en Valencia" width="100%" height="560" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Carrer%20de%20la%20Mar%2024%2C%2046003%20Valencia&output=embed"></iframe>
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
                        <p class="subtitulo" data-i18n="opiniones">Opiniones</p>
                        <h2 data-i18n="opinionesTitulo">Lo que dicen de Shushiara</h2>
                    </div>
                    <div class="col-lg-5">
                        <div class="puntuacion-global">
                            <strong>4,8/5</strong>
                            <span>★★★★★</span>
                            <p data-i18n="valoracionClientes">Valoracion media de nuestros clientes</p>
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
                        <span data-i18n="footerDescripcion1">Restaurante japones con sushi fresco.</span>
                        <span data-i18n="footerDescripcion2">Reservas en local y pedidos a domicilio.</span>
                    </p>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3 data-i18n="menu">Menu</h3>
                    <a href="#inicio" data-i18n="inicio">Inicio</a>
                    <a href="#quienes-somos" data-i18n="quienesSomos">Quienes somos</a>
                    <a href="paginas/pedido.php" data-i18n="carta">Carta</a>
                    <a href="#horarios" data-i18n="horarios">Horarios</a>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3 data-i18n="servicios">Servicios</h3>
                    <a href="paginas/reservar.php" data-i18n="reservarMesa">Reservar mesa</a>
                    <a href="paginas/pedido.php" data-i18n="pedidoDomicilio">Pedido a domicilio</a>
                    <a href="paginas/pedido.php" data-i18n="recogidaLocal">Recogida en local</a>
                    <a class="enlace-interno" href="administracion/login.php" data-i18n="accesoInterno">Acceso interno</a>
                </div>
                <div class="col-lg-3">
                    <h3 data-i18n="contacto">Contacto</h3>
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
                <span data-i18n="copyright">© 2026 Shushiara. Proyecto de pedidos y reservas.</span>
                <span data-i18n="lema">Sushi tradicional con alma moderna.</span>
                <div class="selector-idioma selector-idioma-footer" aria-label="Idioma">
                    <button class="bandera-boton" type="button" data-language="es" aria-label="Español"><svg class="bandera-svg" viewBox="0 0 36 24" aria-hidden="true"><rect width="36" height="24" fill="#c60b1e"/><rect y="6" width="36" height="12" fill="#ffc400"/></svg></button>
                    <button class="bandera-boton" type="button" data-language="en" aria-label="English"><svg class="bandera-svg" viewBox="0 0 36 24" aria-hidden="true"><rect width="36" height="24" fill="#012169"/><path d="M0 0 36 24M36 0 0 24" stroke="#fff" stroke-width="5"/><path d="M0 0 36 24M36 0 0 24" stroke="#c8102e" stroke-width="3"/><path d="M18 0v24M0 12h36" stroke="#fff" stroke-width="8"/><path d="M18 0v24M0 12h36" stroke="#c8102e" stroke-width="4.8"/></svg></button>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="recursos/js/idiomas.js"></script>
</body>
</html>

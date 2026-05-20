<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shushiara</title>
    <link rel="icon" type="image/svg+xml" href="../recursos/imagenes/logo-shushiara.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../recursos/css/estilos.css?v=banderas-footer-3">
</head>
<body class="pagina-simple">
    <!-- Navegacion superior de reservas. -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-superior">
        <div class="container-xxl">
            <a class="navbar-brand marca" href="../index.php"><img class="logo-nav" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara"></a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="../index.php" data-i18n="inicio">Inicio</a>
                <a class="btn btn-sushi" href="pedido.php" data-i18n="hacerPedido">Hacer pedido</a>
            </div>
        </div>
    </nav>

    <!-- Cabecera visual de la pagina de reservas. -->
    <header class="cabecera-reserva">
        <div class="container-xxl">
            <div class="row g-4 align-items-end">
                <div class="col-lg-7">
                    <p class="subtitulo" data-i18n="reservaOnline">Reserva online</p>
                    <h1 data-i18n="mesaShushiara">Mesa en Shushiara</h1>
                    <p data-i18n="reservaIntro">Ven a disfrutar sushi fresco en sala, terraza o barra. Reserva tu mesa en segundos.</p>
                </div>
                <div class="col-lg-5">
                    <div class="pedido-datos">
                        <div><span data-i18n="valoracion">Valoracion</span><strong>4,8/5</strong></div>
                        <div><span data-i18n="ambiente">Ambiente</span><strong data-i18n="localJapones">Local japones</strong></div>
                        <div><span data-i18n="zona">Zona</span><strong data-i18n="salaTerraza">Sala y terraza</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Zona principal: informacion del local y formulario de reserva. -->
    <main class="py-5 reserva-main">
        <div class="container-xxl">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5">
                    <!-- Bloque informativo para explicar como funciona la reserva. -->
                    <div class="reserva-info">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=85" alt="Interior de restaurante">
                        <div class="p-4">
                            <p class="subtitulo" data-i18n="tuMesa">Tu mesa</p>
                            <h2 data-i18n="experiencia">Una experiencia tranquila para comer sushi bien.</h2>
                            <ul>
                                <li data-i18n="mesaInfo1">Mesas para comidas, cenas y celebraciones.</li>
                                <li data-i18n="mesaInfo2">Barra sushi para ver la preparacion en directo.</li>
                                <li data-i18n="mesaInfo3">Terraza disponible segun clima y aforo.</li>
                                <li data-i18n="mesaInfo4">Confirmacion telefonica de la reserva.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <!-- Formulario que JavaScript envia a servicios/reservas.php. -->
                    <div class="bloque-cuadrado p-4 p-md-5 h-100">
                        <p class="subtitulo" data-i18n="datosReserva">Datos de reserva</p>
                        <h2 class="mb-4" data-i18n="reservarMesa">Reservar mesa</h2>
                        <form id="reservaRapida">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="nombre_cliente" data-i18n="nombre">Nombre</label>
                                    <input class="form-control" id="nombre_cliente" name="nombre_cliente" required maxlength="120">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="telefono_cliente" data-i18n="telefono">Telefono</label>
                                    <input class="form-control" id="telefono_cliente" name="telefono_cliente" required maxlength="30">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="email_cliente" data-i18n="email">Email</label>
                                    <input class="form-control" id="email_cliente" type="email" name="email_cliente" maxlength="120">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="fecha_reserva" data-i18n="fecha">Fecha</label>
                                    <input class="form-control" id="fecha_reserva" type="date" name="fecha_reserva" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="hora_reserva" data-i18n="hora">Hora</label>
                                    <select class="form-select" id="hora_reserva" name="hora_reserva" required>
                                        <option value="" data-i18n="seleccionaHora">Selecciona hora</option>
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
                                <div class="col-md-4">
                                    <label class="form-label" for="personas" data-i18n="personas">Personas</label>
                                    <input class="form-control" id="personas" type="number" name="personas" min="1" max="16" value="2" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="zona" data-i18n="zona">Zona</label>
                                    <select class="form-select" id="zona" name="zona">
                                        <option value="sala">Sala</option>
                                        <option value="terraza">Terraza</option>
                                        <option value="barra">Barra sushi</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="ocasion" data-i18n="ocasion">Ocasion</label>
                                    <input class="form-control" id="ocasion" name="ocasion" maxlength="80" placeholder="Cena, cumpleanos, empresa...">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="notas" data-i18n="notas">Notas</label>
                                    <textarea class="form-control" id="notas" name="notas" rows="4" placeholder="Alergias, trona, mesa tranquila..."></textarea>
                                </div>
                            </div>
                            <div class="reserva-sin-pago mt-3">
                                <strong data-i18n="reservaSinPago">Reserva sin pago previo</strong>
                                <span data-i18n="reservaSinPagoInfo">Solo guardamos tus datos para confirmar la mesa. No se cobra nada al reservar.</span>
                            </div>
                            <button class="btn btn-sushi mt-4" type="submit" data-i18n="enviarReserva">Enviar reserva</button>
                            <p class="form-message mt-3" id="reservaMensaje" role="status"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Informacion util para que la pagina de reserva no termine vacia antes del footer. -->
    <section class="py-5 reserva-extra">
        <div class="container-xxl">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <p class="subtitulo" data-i18n="reservaPreparada">Reserva preparada</p>
                    <h2 data-i18n="antesVenirTitulo">Todo listo antes de sentarte.</h2>
                    <p class="texto-suave" data-i18n="antesVenirTexto">Al enviar la reserva guardamos tus datos y el equipo revisa disponibilidad real de sala, barra o terraza. Si hace falta ajustar algo, te llamamos antes del servicio.</p>
                </div>
                <div class="col-lg-7">
                    <div class="bloque-cuadrado reserva-consejos">
                        <div>
                            <span>01</span>
                            <strong data-i18n="consejoReserva1Titulo">Confirmacion telefonica</strong>
                            <p data-i18n="consejoReserva1Texto">La reserva queda registrada y se confirma por telefono si el local necesita revisar aforo.</p>
                        </div>
                        <div>
                            <span>02</span>
                            <strong data-i18n="consejoReserva2Titulo">Sin pago previo</strong>
                            <p data-i18n="consejoReserva2Texto">No se cobra nada al reservar mesa. El pago solo se realiza en el restaurante.</p>
                        </div>
                        <div>
                            <span>03</span>
                            <strong data-i18n="consejoReserva3Titulo">Alergias y preferencias</strong>
                            <p data-i18n="consejoReserva3Texto">Puedes indicar alergias, trona, celebraciones o una mesa tranquila en el campo de notas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer publico con contacto y enlaces. -->
    <footer class="pie">
        <div class="container-xxl">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <img class="logo-footer" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara">
                    <p>
                        <span data-i18n="footerDescripcion1">Restaurante japones con sushi fresco.</span>
                        <span data-i18n="footerDescripcion2">Reservas en local y pedidos a domicilio.</span>
                    </p>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3 data-i18n="menu">Menu</h3>
                    <a href="../index.php" data-i18n="inicio">Inicio</a>
                    <a href="../index.php#quienes-somos" data-i18n="quienesSomos">Quienes somos</a>
                    <a href="pedido.php" data-i18n="carta">Carta</a>
                    <a href="../index.php#horarios" data-i18n="horarios">Horarios</a>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <h3 data-i18n="servicios">Servicios</h3>
                    <a href="reservar.php" data-i18n="reservarMesa">Reservar mesa</a>
                    <a href="pedido.php" data-i18n="pedidoDomicilio">Pedido a domicilio</a>
                    <a href="pedido.php" data-i18n="recogidaLocal">Recogida en local</a>
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

    <script src="../recursos/js/reservas.js"></script>
    <script src="../recursos/js/idiomas.js"></script>
</body>
</html>

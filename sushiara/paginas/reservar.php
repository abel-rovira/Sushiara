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
    <!-- Navegacion superior de reservas. -->
    <nav class="navbar navbar-expand-lg navbar-dark barra-superior">
        <div class="container-xxl">
            <a class="navbar-brand marca" href="../index.php"><img class="logo-nav" src="../recursos/imagenes/logo-shushiara.svg" alt="Shushiara"></a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="../index.php">Inicio</a>
                <a class="btn btn-sushi" href="pedido.php">Hacer pedido</a>
            </div>
        </div>
    </nav>

    <!-- Cabecera visual de la pagina de reservas. -->
    <header class="cabecera-reserva">
        <div class="container-xxl">
            <div class="row g-4 align-items-end">
                <div class="col-lg-7">
                    <p class="subtitulo">Reserva online</p>
                    <h1>Mesa en Shushiara</h1>
                    <p>Ven a disfrutar sushi fresco en sala, terraza o barra. Reserva tu mesa en segundos.</p>
                </div>
                <div class="col-lg-5">
                    <div class="pedido-datos">
                        <div><span>Valoracion</span><strong>4,8/5</strong></div>
                        <div><span>Ambiente</span><strong>Local japones</strong></div>
                        <div><span>Zona</span><strong>Sala y terraza</strong></div>
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
                            <p class="subtitulo">Tu mesa</p>
                            <h2>Una experiencia tranquila para comer sushi bien.</h2>
                            <ul>
                                <li>Mesas para comidas, cenas y celebraciones.</li>
                                <li>Barra sushi para ver la preparacion en directo.</li>
                                <li>Terraza disponible segun clima y aforo.</li>
                                <li>Confirmacion telefonica de la reserva.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <!-- Formulario que JavaScript envia a servicios/reservas.php. -->
                    <div class="bloque-cuadrado p-4 p-md-5 h-100">
                        <p class="subtitulo">Datos de reserva</p>
                        <h2 class="mb-4">Reservar mesa</h2>
                        <form id="reservaRapida">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="nombre_cliente">Nombre</label>
                                    <input class="form-control" id="nombre_cliente" name="nombre_cliente" required maxlength="120">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="telefono_cliente">Telefono</label>
                                    <input class="form-control" id="telefono_cliente" name="telefono_cliente" required maxlength="30">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="email_cliente">Email</label>
                                    <input class="form-control" id="email_cliente" type="email" name="email_cliente" maxlength="120">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="fecha_reserva">Fecha</label>
                                    <input class="form-control" id="fecha_reserva" type="date" name="fecha_reserva" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="hora_reserva">Hora</label>
                                    <select class="form-select" id="hora_reserva" name="hora_reserva" required>
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
                                <div class="col-md-4">
                                    <label class="form-label" for="personas">Personas</label>
                                    <input class="form-control" id="personas" type="number" name="personas" min="1" max="16" value="2" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="zona">Zona</label>
                                    <select class="form-select" id="zona" name="zona">
                                        <option value="sala">Sala</option>
                                        <option value="terraza">Terraza</option>
                                        <option value="barra">Barra sushi</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="ocasion">Ocasion</label>
                                    <input class="form-control" id="ocasion" name="ocasion" maxlength="80" placeholder="Cena, cumpleanos, empresa...">
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="notas">Notas</label>
                                    <textarea class="form-control" id="notas" name="notas" rows="4" placeholder="Alergias, trona, mesa tranquila..."></textarea>
                                </div>
                            </div>
                            <div class="reserva-sin-pago mt-3">
                                <strong>Reserva sin pago previo</strong>
                                <span>Solo guardamos tus datos para confirmar la mesa. No se cobra nada al reservar.</span>
                            </div>
                            <button class="btn btn-sushi mt-4" type="submit">Enviar reserva</button>
                            <p class="form-message mt-3" id="reservaMensaje" role="status"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Datos rapidos del restaurante. -->
    <section class="py-5 horarios">
        <div class="container-xxl">
            <div class="row g-4">
                <div class="col-md-4"><div class="mini-dato"><span>Direccion</span><strong>Carrer de la Mar 24, Valencia</strong></div></div>
                <div class="col-md-4"><div class="mini-dato"><span>Telefono</span><strong>600 123 456</strong></div></div>
                <div class="col-md-4"><div class="mini-dato"><span>Horario</span><strong>L-J 23:30 / V-S 00:00 / D 23:00</strong></div></div>
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

    <script src="../recursos/js/reservas.js"></script>
</body>
</html>

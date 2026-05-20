<?php

declare(strict_types=1);

// Cargamos conexion a MySQL y funciones comunes para responder en JSON.
require __DIR__ . '/../incluye/bd.php';
require __DIR__ . '/../incluye/funciones.php';

// Este servicio solo acepta POST, porque sirve para crear pedidos.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respuesta_json(['ok' => false, 'message' => 'Metodo no permitido.'], 405);
}

// Leemos el JSON enviado desde JavaScript.
$payload = json_decode(file_get_contents('php://input'), true);

// Si el JSON no se pudo convertir en array, los datos no son validos.
if (!is_array($payload)) {
    respuesta_json(['ok' => false, 'message' => 'Datos invalidos.'], 400);
}

// Extraemos y limpiamos los datos principales del cliente.
$nombreCliente = trim((string) ($payload['nombre_cliente'] ?? ''));
$telefonoCliente = trim((string) ($payload['telefono_cliente'] ?? ''));
$direccionCliente = trim((string) ($payload['direccion_cliente'] ?? ''));

// Extraemos datos de entrega, pago y notas.
$tipoEntrega = trim((string) ($payload['tipo_entrega'] ?? 'domicilio'));
$fechaEntrega = trim((string) ($payload['fecha_entrega'] ?? ''));
$horaEntrega = trim((string) ($payload['hora_entrega'] ?? ''));
$metodoPago = trim((string) ($payload['metodo_pago'] ?? 'tarjeta'));
$notas = trim((string) ($payload['notas'] ?? ''));

// Datos del pago simulado. Se validan, pero no se guarda informacion sensible completa.
$titularTarjeta = trim((string) ($payload['titular_tarjeta'] ?? ''));
$numeroTarjeta = preg_replace('/\D+/', '', (string) ($payload['numero_tarjeta'] ?? ''));
$caducidadTarjeta = trim((string) ($payload['caducidad_tarjeta'] ?? ''));
$cvvTarjeta = preg_replace('/\D+/', '', (string) ($payload['cvv_tarjeta'] ?? ''));
$telefonoBizum = trim((string) ($payload['telefono_bizum'] ?? ''));
$referenciaPago = null;

// Tarifa unica de desplazamiento cuando el pedido es a domicilio.
$costeEnvioDomicilio = 5.00;

// Horas disponibles por dia. Viernes y sabado se trabaja hasta las 00:00,
// asi que la ultima franja que se puede seleccionar es 23:30.
$horariosRestaurante = [
    'entreSemana' => ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00'],
    'viernesSabado' => ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'],
    'domingo' => ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'],
];

// Devuelve las horas validas segun la fecha seleccionada.
function horas_disponibles_por_fecha(string $fecha, array $horariosRestaurante): array
{
    if ($fecha === '') {
        return array_values(array_unique(array_merge(...array_values($horariosRestaurante))));
    }

    $diaSemana = (int) date('w', strtotime($fecha));

    if ($diaSemana === 0) {
        return $horariosRestaurante['domingo'];
    }

    if ($diaSemana === 5 || $diaSemana === 6) {
        return $horariosRestaurante['viernesSabado'];
    }

    return $horariosRestaurante['entreSemana'];
}

// Normaliza telefonos quitando espacios, guiones y parentesis para validarlos mejor.
function telefono_valido(string $telefono): bool
{
    // Quitamos cualquier caracter que no sea numero para aceptar formatos habituales.
    $telefonoLimpio = preg_replace('/\D+/', '', $telefono);

    return strlen($telefonoLimpio) >= 9 && strlen($telefonoLimpio) <= 15;
}

// Articulos viene del carrito de JavaScript.
$items = $payload['articulos'] ?? [];

// Validacion basica de campos obligatorios.
if ($nombreCliente === '' || $telefonoCliente === '' || $direccionCliente === '') {
    respuesta_json(['ok' => false, 'message' => 'Completa tus datos de entrega.'], 422);
}

// Validamos telefono aceptando formatos como 600123456, 600 123 456 o +34 600 123 456.
if (!telefono_valido($telefonoCliente)) {
    respuesta_json(['ok' => false, 'message' => 'Introduce un telefono valido.'], 422);
}

// Solo aceptamos tipos de entrega definidos por nosotros.
if (!in_array($tipoEntrega, ['domicilio', 'recogida'], true)) {
    respuesta_json(['ok' => false, 'message' => 'Selecciona un tipo de entrega valido.'], 422);
}

// Solo aceptamos metodos de pago definidos por nosotros.
if (!in_array($metodoPago, ['tarjeta', 'efectivo', 'bizum'], true)) {
    respuesta_json(['ok' => false, 'message' => 'Selecciona un metodo de pago valido.'], 422);
}

// Validamos tarjeta simulada sin guardar el numero completo en la base de datos.
if ($metodoPago === 'tarjeta') {
    if ($titularTarjeta === '' || strlen($numeroTarjeta) < 13 || strlen($numeroTarjeta) > 19 || !preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $caducidadTarjeta) || strlen($cvvTarjeta) < 3 || strlen($cvvTarjeta) > 4) {
        respuesta_json(['ok' => false, 'message' => 'Completa correctamente los datos de la tarjeta simulada.'], 422);
    }

    $referenciaPago = 'Tarjeta simulada **** ' . substr($numeroTarjeta, -4);
}

// Validamos Bizum simulado con un telefono parecido al del cliente.
if ($metodoPago === 'bizum') {
    if (!telefono_valido($telefonoBizum)) {
        respuesta_json(['ok' => false, 'message' => 'Introduce un telefono Bizum valido.'], 422);
    }

    $referenciaPago = 'Bizum simulado ' . $telefonoBizum;
}

// El efectivo no necesita datos adicionales porque se paga al recibir o recoger.
if ($metodoPago === 'efectivo') {
    $referenciaPago = 'Pago pendiente en efectivo';
}

// No se puede crear un pedido sin articulos.
if (!is_array($items) || count($items) === 0) {
    respuesta_json(['ok' => false, 'message' => 'Anade productos al carrito.'], 422);
}

// Si el cliente elige una fecha, no permitimos fechas anteriores a hoy.
if ($fechaEntrega !== '' && $fechaEntrega < date('Y-m-d')) {
    respuesta_json(['ok' => false, 'message' => 'La fecha de entrega no puede ser anterior a hoy.'], 422);
}

// La hora del pedido es obligatoria para trabajar siempre con una franja concreta.
if ($horaEntrega === '') {
    respuesta_json(['ok' => false, 'message' => 'Selecciona la hora de entrega.'], 422);
}

// La hora debe estar dentro del horario del dia elegido.
if ($horaEntrega !== '' && !in_array(substr($horaEntrega, 0, 5), horas_disponibles_por_fecha($fechaEntrega, $horariosRestaurante), true)) {
    respuesta_json(['ok' => false, 'message' => 'Selecciona una hora disponible segun el dia elegido.'], 422);
}

// Si se programa una hora concreta, tambien debe indicarse la fecha.
if ($horaEntrega !== '' && $fechaEntrega === '') {
    respuesta_json(['ok' => false, 'message' => 'Selecciona tambien la fecha de entrega para programar una hora.'], 422);
}

// No permitimos programar un pedido para una hora que ya ha pasado.
if ($fechaEntrega !== '' && $horaEntrega !== '') {
    $fechaHoraEntrega = DateTime::createFromFormat('Y-m-d H:i', $fechaEntrega . ' ' . substr($horaEntrega, 0, 5));

    if (!$fechaHoraEntrega || $fechaHoraEntrega <= new DateTime()) {
        respuesta_json(['ok' => false, 'message' => 'La hora de entrega no puede estar en el pasado.'], 422);
    }
}

// Guardamos ids y cantidades por separado para validar los productos contra la base de datos.
$idsProductos = [];
$cantidades = [];

foreach ($items as $item) {
    // Convertimos id y cantidad a enteros para evitar datos raros.
    $productId = (int) ($item['id'] ?? 0);
    $quantity = (int) ($item['cantidad'] ?? 0);

    if ($productId <= 0 || $quantity <= 0) {
        respuesta_json(['ok' => false, 'message' => 'Hay productos invalidos en el carrito.'], 422);
    }

    // Si el mismo producto viene dos veces, sumamos cantidades.
    $idsProductos[] = $productId;
    $cantidades[$productId] = ($cantidades[$productId] ?? 0) + $quantity;
}

// Quitamos ids repetidos para consultar cada producto una sola vez.
$idsProductosUnicos = array_values(array_unique($idsProductos));

// Creamos placeholders seguros para PDO: ?, ?, ?, ...
$placeholders = implode(',', array_fill(0, count($idsProductosUnicos), '?'));

// Consultamos productos reales y activos para evitar confiar en precios enviados por JavaScript.
$productStatement = $pdo->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1 AND id IN ({$placeholders})");
$productStatement->execute($idsProductosUnicos);
$productos = $productStatement->fetchAll();

// Si falta algun producto, puede que este inactivo o no exista.
if (count($productos) !== count($idsProductosUnicos)) {
    respuesta_json(['ok' => false, 'message' => 'Alguno de los productos ya no esta disponible.'], 422);
}

// Calculamos total y preparamos los detalles que iran en detalles_pedido.
$total = 0.0;
$detallesPedido = [];

foreach ($productos as $producto) {
    $quantity = $cantidades[(int) $producto['id']];
    $unitPrice = (float) $producto['precio'];
    $subtotal = $unitPrice * $quantity;
    $total += $subtotal;

    $detallesPedido[] = [
        'producto_id' => (int) $producto['id'],
        'nombre_producto' => $producto['nombre'],
        'precio_unitario' => $unitPrice,
        'quantity' => $quantity,
        'subtotal' => $subtotal,
    ];
}

// Gastos de envio: solo se cobran si es domicilio. En recogida se mantiene a cero.
$subtotalPedido = $total;
$gastosEnvio = $tipoEntrega === 'domicilio' ? $costeEnvioDomicilio : 0.00;
$totalPedido = $subtotalPedido + $gastosEnvio;

// Pedido minimo antes de envio.
if ($subtotalPedido < 12.00) {
    respuesta_json(['ok' => false, 'message' => 'El pedido minimo es de 12,00 EUR.'], 422);
}

try {
    // Transaccion: o se guarda el pedido completo con sus productos, o no se guarda nada.
    $pdo->beginTransaction();

    // Insertamos la cabecera del pedido.
    $orderStatement = $pdo->prepare(
        'INSERT INTO pedidos (nombre_cliente, telefono_cliente, direccion_cliente, tipo_entrega, fecha_entrega, hora_entrega, metodo_pago, pago_simulado, referencia_pago, notas, 
        subtotal, gastos_envio, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $orderStatement->execute([
        $nombreCliente,
        $telefonoCliente,
        $direccionCliente,
        $tipoEntrega,
        $fechaEntrega !== '' ? $fechaEntrega : null,
        $horaEntrega !== '' ? $horaEntrega : null,
        $metodoPago,
        1,
        $referenciaPago,
        $notas,
        $subtotalPedido,
        $gastosEnvio,
        $totalPedido,
    ]);

    // Guardamos el id del pedido recien creado para asociar sus productos.
    $orderId = (int) $pdo->lastInsertId();

    // Preparamos una sola consulta para insertar cada producto del pedido.
    $itemStatement = $pdo->prepare(
        'INSERT INTO detalles_pedido (pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES (?, ?, ?, ?, ?, ?)'
    );

    foreach ($detallesPedido as $orderItem) {
        $itemStatement->execute([
            $orderId,
            $orderItem['producto_id'],
            $orderItem['nombre_producto'],
            $orderItem['precio_unitario'],
            $orderItem['quantity'],
            $orderItem['subtotal'],
        ]);
    }

    // Confirmamos los cambios en base de datos.
    $pdo->commit();

    // Respondemos al navegador con el numero de pedido y total.
    respuesta_json([
        'ok' => true,
        'message' => 'Pedido recibido correctamente.',
        'order_id' => $orderId,
        'total' => dinero($totalPedido),
        'pago' => 'Pago simulado registrado.',
    ], 201);
} catch (Throwable $exception) {
    // Si algo falla, deshacemos la transaccion.
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    respuesta_json(['ok' => false, 'message' => 'No se pudo guardar el pedido.'], 500);
}

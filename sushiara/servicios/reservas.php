<?php

declare(strict_types=1);

// Cargamos conexion y funcion para responder JSON.
require __DIR__ . '/../incluye/bd.php';
require __DIR__ . '/../incluye/funciones.php';

// Este endpoint solo crea reservas, por eso exige POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respuesta_json(['ok' => false, 'message' => 'Metodo no permitido.'], 405);
}

// Leemos el JSON que envia JavaScript.
$payload = json_decode(file_get_contents('php://input'), true);

if (!is_array($payload)) {
    respuesta_json(['ok' => false, 'message' => 'Datos invalidos.'], 400);
}

// Recogemos campos del formulario de reserva.
$nombreCliente = trim((string) ($payload['nombre_cliente'] ?? ''));
$telefonoCliente = trim((string) ($payload['telefono_cliente'] ?? ''));
$emailCliente = trim((string) ($payload['email_cliente'] ?? ''));
$fechaReserva = trim((string) ($payload['fecha_reserva'] ?? ''));
$horaReserva = trim((string) ($payload['hora_reserva'] ?? ''));
$personas = (int) ($payload['personas'] ?? 0);
$zona = trim((string) ($payload['zona'] ?? 'sala'));
$ocasion = trim((string) ($payload['ocasion'] ?? ''));
$notas = trim((string) ($payload['notas'] ?? ''));

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

// Validamos que los datos principales esten completos.
if ($nombreCliente === '' || $telefonoCliente === '' || $fechaReserva === '' || $horaReserva === '' || $personas <= 0) {
    respuesta_json(['ok' => false, 'message' => 'Completa los datos principales de la reserva.'], 422);
}

// Validamos telefono aceptando formatos como 600123456, 600 123 456 o +34 600 123 456.
if (!telefono_valido($telefonoCliente)) {
    respuesta_json(['ok' => false, 'message' => 'Introduce un telefono valido.'], 422);
}

// Si hay email, comprobamos que tenga formato correcto.
if ($emailCliente !== '' && !filter_var($emailCliente, FILTER_VALIDATE_EMAIL)) {
    respuesta_json(['ok' => false, 'message' => 'Introduce un email valido.'], 422);
}

// No permitimos reservar en fechas pasadas.
if ($fechaReserva < date('Y-m-d')) {
    respuesta_json(['ok' => false, 'message' => 'La fecha de reserva no puede ser anterior a hoy.'], 422);
}

// No permitimos reservas fuera del horario real del restaurante.
if (!in_array(substr($horaReserva, 0, 5), horas_disponibles_por_fecha($fechaReserva, $horariosRestaurante), true)) {
    respuesta_json(['ok' => false, 'message' => 'Selecciona una hora disponible segun el dia elegido.'], 422);
}

// Tampoco se permite reservar para una hora anterior a la actual.
if ($fechaReserva !== '' && $horaReserva !== '') {
    $fechaHoraReserva = DateTime::createFromFormat('Y-m-d H:i', $fechaReserva . ' ' . substr($horaReserva, 0, 5));

    if (!$fechaHoraReserva || $fechaHoraReserva <= new DateTime()) {
        respuesta_json(['ok' => false, 'message' => 'La hora de reserva no puede estar en el pasado.'], 422);
    }
}

// Limitamos reservas grandes para que llamen al restaurante.
if ($personas > 16) {
    respuesta_json(['ok' => false, 'message' => 'Para mas de 16 personas llama al restaurante.'], 422);
}

// Solo aceptamos zonas que existen en la base de datos.
if (!in_array($zona, ['sala', 'terraza', 'barra'], true)) {
    respuesta_json(['ok' => false, 'message' => 'Selecciona una zona valida.'], 422);
}

try {
    // Insertamos la reserva en MySQL.
    $statement = $pdo->prepare(
        'INSERT INTO reservas (nombre_cliente, telefono_cliente, email_cliente, fecha_reserva, hora_reserva, personas, zona, ocasion, notas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $statement->execute([
        $nombreCliente,
        $telefonoCliente,
        $emailCliente !== '' ? $emailCliente : null,
        $fechaReserva,
        $horaReserva,
        $personas,
        $zona,
        $ocasion !== '' ? $ocasion : null,
        $notas,
    ]);

    // Devolvemos el id de reserva al navegador.
    respuesta_json([
        'ok' => true,
        'message' => 'Reserva recibida correctamente.',
        'reserva_id' => (int) $pdo->lastInsertId(),
    ], 201);
} catch (Throwable $exception) {
    respuesta_json(['ok' => false, 'message' => 'No se pudo guardar la reserva.'], 500);
}

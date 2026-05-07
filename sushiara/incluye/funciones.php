<?php

declare(strict_types=1);

// Envia una respuesta JSON al navegador y termina la ejecucion.
function respuesta_json(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Formatea numeros como dinero en euros para mostrarlos en administracion o respuestas.
function dinero(float $amount): string
{
    return number_format($amount, 2, ',', '.') . ' EUR';
}

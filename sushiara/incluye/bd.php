<?php

declare(strict_types=1);

// Datos de conexion a MySQL. En XAMPP normalmente el usuario es root y no tiene contrasena.
$host = 'localhost';
$database = 'sushiara';
$user = 'root';
$password = '';

try {
    // Creamos un objeto PDO, que es la forma segura de conectar PHP con MySQL.
    $pdo = new PDO(
        "mysql:host={$host};dbname={$database};charset=utf8mb4",
        $user,
        $password,
        [
            // Si MySQL falla, PDO lanzara excepciones para poder detectar errores.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Las consultas devolveran arrays asociativos: $fila['nombre'].
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $exception) {
    // Si no se puede conectar, paramos la pagina con un error 500.
    http_response_code(500);
    exit('Error de conexion con la base de datos.');
}

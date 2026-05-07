# Guia rapida de Sushiara

## Importante

Si ya importaste una version anterior de la base de datos, vuelve a importar `base_de_datos/esquema.sql`.
El script recrea las tablas para dejar el proyecto con productos, pedidos y reservas actualizados.

## Flujo de pedido

1. El cliente abre `index.php`.
2. Filtra o busca productos.
3. Anade productos al carrito.
4. Rellena datos de entrega y pago.
5. `servicios/pedidos.php` guarda el pedido en MySQL.
6. El restaurante lo ve en `administracion/pedidos.php`.

## Flujo de reserva

1. El cliente usa la reserva rapida de la portada o `paginas/reservar.php`.
2. `servicios/reservas.php` guarda la reserva.
3. El restaurante la ve en `administracion/reservas.php`.

## Estilo

El diseño usa Bootstrap 5 por CDN y un CSS propio en `recursos/css/estilos.css`.
La linea visual es seria y profesional: bloques cuadrados, negro, blanco y rojo, parecida a paginas de delivery de restaurante.

# AGENTS.md

## Contexto del proyecto

Shushiara es una aplicacion web de restaurante japones creada para un proyecto final de 2DAW. Permite mostrar una web publica, consultar carta, realizar pedidos, simular pagos, reservar mesa y gestionar pedidos/reservas desde un panel interno.

## Tecnologias

- PHP puro.
- MySQL/MariaDB.
- PDO para la conexion a base de datos.
- JavaScript puro.
- HTML5 y CSS3.
- Bootstrap 5 por CDN.
- phpMyAdmin para importar y revisar la base de datos.
- XAMPP como entorno local recomendado.

## Estructura principal

- `index.php`: pagina principal publica.
- `paginas/pedido.php`: carta, carrito, formulario de pedido y pago simulado.
- `paginas/reservar.php`: formulario de reserva de mesa sin pago previo.
- `servicios/pedidos.php`: endpoint que valida, recalcula y guarda pedidos.
- `servicios/reservas.php`: endpoint que valida y guarda reservas.
- `administracion/login.php`: acceso interno.
- `administracion/pedidos.php`: gestion de pedidos, estados y referencias de pago.
- `administracion/reservas.php`: gestion de reservas.
- `administracion/seguridad.php`: funciones de sesion y proteccion del panel.
- `incluye/bd.php`: conexion a MySQL.
- `incluye/funciones.php`: respuestas JSON y formato de dinero.
- `base_de_datos/esquema.sql`: creacion de tablas y datos iniciales.
- `recursos/css/estilos.css`: estilos personalizados.
- `recursos/js/aplicacion.js`: carrito, filtros, horarios, pago simulado y envio de pedidos.
- `recursos/js/reservas.js`: horarios y envio de reservas.
- `documentacion/memoria_shushiara.odt`: memoria del proyecto.
- `documentacion/uso.md`: notas de uso.

## Credenciales de administracion

- Usuario: `admin`
- Contrasena: `shushiara123`

La contrasena no se guarda en texto plano. Se guarda como hash en la tabla `administradores`.

## Reglas funcionales actuales

- Pedidos a domicilio: gastos de envio de `5,00 EUR`.
- Recogida en local: gastos de envio de `0,00 EUR`.
- Pedido minimo: `12,00 EUR` antes de envio.
- Pago: simulado, nunca real.
- Tarjeta: no guardar datos completos, solo referencia segura.
- Bizum: validar telefono y guardar referencia simulada.
- Efectivo: guardar pago pendiente en efectivo.
- Reservas: no tienen pago previo.
- Hora de pedido: obligatoria, sin opcion "lo antes posible".

## Horarios validos

- Lunes a jueves: `13:00 - 16:00 / 20:00 - 23:30`
- Viernes y sabado: `13:00 - 16:30 / 20:00 - 00:00`
- Domingo: `13:00 - 16:00 / 20:00 - 23:00`

Las horas se muestran en franjas de 30 minutos. Viernes y sabado la ultima franja seleccionable es `23:30` porque el cierre es a `00:00`.

## Reglas de mantenimiento

- Mantener nombres de carpetas y archivos en espanol.
- Mantener PHP puro y JavaScript puro.
- No anadir frameworks nuevos si no son necesarios.
- Si se cambia la base de datos, actualizar `base_de_datos/esquema.sql` y `README.md`.
- Si se cambia una ruta publica, actualizar navegacion, footer y README.
- Si se cambia una regla de negocio, actualizar JavaScript y PHP, porque ambos validan.
- No guardar datos sensibles de tarjeta.
- Mantener comentarios en la logica importante para que el proyecto sea defendible.
- Copiar los cambios a `C:\xampp\htdocs\sushiara` si se quieren probar en `localhost`.


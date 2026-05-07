# Shushiara

Shushiara es una aplicacion web para un restaurante japones. Permite mostrar una pagina publica profesional, consultar la carta, realizar pedidos a domicilio o recogida, reservar mesa y gestionar pedidos/reservas desde un panel interno de administracion.

El proyecto esta preparado para un entorno local con XAMPP, PHP puro, MySQL/phpMyAdmin, JavaScript puro, CSS personalizado y Bootstrap.

## Objetivos

- Crear una web profesional para un restaurante de sushi.
- Mostrar informacion del local, horarios, opiniones, carta y servicios.
- Permitir pedidos desde una carta online con carrito.
- Simular pagos por tarjeta, Bizum o efectivo sin realizar cobros reales.
- Permitir reservas de mesa sin pago previo.
- Guardar pedidos, detalles de pedido y reservas en MySQL.
- Proteger la administracion mediante login y sesiones PHP.
- Permitir al administrador cambiar estados de pedidos y reservas.
- Mantener el codigo organizado, comentado y facil de explicar.

## Tecnologias utilizadas

- `HTML5`: estructura de las paginas.
- `CSS3`: estilos personalizados.
- `Bootstrap 5`: sistema responsive y componentes base.
- `JavaScript puro`: carrito, filtros, validaciones y llamadas `fetch`.
- `PHP puro`: backend, servicios y panel de administracion.
- `PDO`: conexion segura entre PHP y MySQL.
- `MySQL/MariaDB`: base de datos.
- `phpMyAdmin`: importacion y revision de la base de datos.
- `XAMPP`: entorno local recomendado.

## Estructura de carpetas

```text
sushiara/
|-- administracion/
|   |-- actualizar_pedido.php
|   |-- actualizar_reserva.php
|   |-- login.php
|   |-- pedidos.php
|   |-- reservas.php
|   |-- salir.php
|   `-- seguridad.php
|-- base_de_datos/
|   `-- esquema.sql
|-- documentacion/
|   |-- memoria_shushiara.odt
|   `-- uso.md
|-- incluye/
|   |-- bd.php
|   `-- funciones.php
|-- paginas/
|   |-- pedido.php
|   `-- reservar.php
|-- recursos/
|   |-- css/
|   |   `-- estilos.css
|   |-- imagenes/
|   |   `-- logo-shushiara.svg
|   `-- js/
|       |-- aplicacion.js
|       `-- reservas.js
|-- servicios/
|   |-- pedidos.php
|   `-- reservas.php
|-- AGENTS.md
|-- index.php
`-- README.md
```

## Instalacion paso a paso

1. Instala y abre XAMPP.
2. Activa `Apache` y `MySQL`.
3. Copia la carpeta `sushiara` dentro de `C:\xampp\htdocs\`.
4. La ruta final debe quedar asi:

```text
C:\xampp\htdocs\sushiara
```

5. Abre phpMyAdmin:

[http://localhost/phpmyadmin](http://localhost/phpmyadmin)

6. Importa el archivo SQL:

```text
sushiara/base_de_datos/esquema.sql
```

El script crea la base de datos `sushiara`, crea las tablas y carga productos iniciales.

7. Revisa la conexion en `sushiara/incluye/bd.php`.

Por defecto esta preparada para XAMPP:

```php
$host = 'localhost';
$database = 'sushiara';
$user = 'root';
$password = '';
```

8. Abre la web:

[http://localhost/sushiara/](http://localhost/sushiara/)

## Rutas principales

Web publica:

- Inicio: [http://localhost/sushiara/](http://localhost/sushiara/)
- Carta y pedido: [http://localhost/sushiara/paginas/pedido.php](http://localhost/sushiara/paginas/pedido.php)
- Reserva de mesa: [http://localhost/sushiara/paginas/reservar.php](http://localhost/sushiara/paginas/reservar.php)

Administracion:

- Login: [http://localhost/sushiara/administracion/login.php](http://localhost/sushiara/administracion/login.php)
- Pedidos: [http://localhost/sushiara/administracion/pedidos.php](http://localhost/sushiara/administracion/pedidos.php)
- Reservas: [http://localhost/sushiara/administracion/reservas.php](http://localhost/sushiara/administracion/reservas.php)

## Acceso de administracion

```text
Usuario: admin
Contrasena: shushiara123
```

La contrasena se guarda en la tabla `administradores` usando `password_hash`, no en texto plano. El login usa `password_verify` para comparar la clave escrita con el hash guardado.

## Base de datos

La base de datos se llama `sushiara`.

Tablas principales:

- `productos`: productos de la carta, precios, imagenes, categorias y etiquetas.
- `pedidos`: datos generales de cada pedido, entrega, pago simulado, subtotales y estado.
- `detalles_pedido`: lineas de productos incluidas en cada pedido.
- `reservas`: reservas de mesa con fecha, hora, personas, zona y estado.
- `administradores`: usuarios que pueden entrar al panel interno.

## Horarios

Los pedidos y reservas solo permiten horas dentro del horario real del restaurante:

- Lunes a jueves: `13:00 - 16:00 / 20:00 - 23:30`
- Viernes y sabado: `13:00 - 16:30 / 20:00 - 00:00`
- Domingo: `13:00 - 16:00 / 20:00 - 23:00`

En los formularios se trabaja con franjas de 30 minutos. Viernes y sabado el cierre es a `00:00`, por eso la ultima franja seleccionable es `23:30`.

## Funcionamiento del pedido

1. El cliente entra en `paginas/pedido.php`.
2. Filtra productos por categoria o buscador.
3. Pulsa `Anadir` en los productos.
4. JavaScript guarda los productos en un carrito temporal.
5. El cliente elige domicilio o recogida.
6. El cliente rellena nombre, telefono, direccion, fecha, hora y metodo de pago.
7. La hora es obligatoria; no existe la opcion "lo antes posible".
8. JavaScript calcula subtotal, gastos de envio y total visible.
9. JavaScript envia el pedido con `fetch` a `servicios/pedidos.php`.
10. PHP valida los datos, recalcula precios desde MySQL, aplica envio y guarda:
    - cabecera en `pedidos`
    - lineas en `detalles_pedido`
    - referencia segura del pago simulado
11. El administrador puede ver y gestionar el pedido en `administracion/pedidos.php`.

## Pago simulado

El proyecto no integra una pasarela real. Simula el proceso de pago para demostrar el flujo completo de compra.

Metodos disponibles:

- `Tarjeta`: pide titular, numero, caducidad y CVV. No guarda el numero completo; solo guarda una referencia como `Tarjeta simulada **** 4242`.
- `Bizum`: pide telefono Bizum y guarda una referencia tipo `Bizum simulado 600 123 456`.
- `Efectivo`: no pide datos extra y guarda `Pago pendiente en efectivo`.

## Envio

- Pedido a domicilio: suma `5,00 EUR` de gastos de envio.
- Recogida en local: suma `0,00 EUR` de envio.
- Pedido minimo: `12,00 EUR` antes de gastos de envio.

## Funcionamiento de reservas

1. El cliente entra en `paginas/reservar.php`.
2. Rellena nombre, telefono, email opcional, fecha, hora, personas, zona, ocasion y notas.
3. La reserva no pide pago previo.
4. JavaScript bloquea fechas pasadas y horas fuera del horario.
5. JavaScript envia la reserva a `servicios/reservas.php`.
6. PHP valida los datos y guarda la reserva en `reservas`.
7. El administrador puede verla y cambiar su estado en `administracion/reservas.php`.

## Funcionamiento del panel de administracion

1. El administrador entra en `administracion/login.php`.
2. PHP busca el usuario en la tabla `administradores`.
3. `password_verify` valida la contrasena.
4. Si es correcto, se crea una sesion PHP.
5. Las paginas internas usan `exigir_admin()` para impedir accesos sin login.
6. En pedidos se pueden usar los estados:
   - `pendiente`
   - `preparando`
   - `listo`
   - `enviado`
   - `entregado`
   - `cancelado`
7. En reservas se pueden usar los estados:
   - `pendiente`
   - `confirmada`
   - `cancelada`

## Validaciones implementadas

Pedidos:

- No permite carrito vacio.
- Valida nombre, telefono y direccion.
- El telefono acepta formatos como `600123456`, `600 123 456` o `+34 600 123 456`.
- Valida tipo de entrega: `domicilio` o `recogida`.
- Valida metodo de pago: `tarjeta`, `bizum` o `efectivo`.
- Valida fecha no anterior a hoy.
- Hace obligatoria la hora del pedido.
- Valida que la hora elegida respete el horario segun el dia.
- Valida tarjeta simulada, Bizum simulado o efectivo.
- Recalcula precios desde MySQL para no confiar en el navegador.
- Aplica `5,00 EUR` de gastos de envio para domicilio.
- Aplica pedido minimo de `12,00 EUR`.

Reservas:

- Valida nombre, telefono, fecha, hora y numero de personas.
- El telefono acepta formatos como `600123456`, `600 123 456` o `+34 600 123 456`.
- Valida email si se introduce.
- No permite fechas pasadas.
- No permite horas fuera del horario del restaurante.
- No permite reservar para una hora ya pasada.
- Limita reservas a maximo 16 personas.
- Valida zona: `sala`, `terraza` o `barra`.

## Archivos importantes para explicar

- `incluye/bd.php`: conecta PHP con MySQL usando PDO.
- `incluye/funciones.php`: contiene respuestas JSON y formato de dinero.
- `recursos/js/aplicacion.js`: controla carrito, filtros, horarios, pago simulado y envio de pedidos.
- `recursos/js/reservas.js`: valida horarios de reserva y envia reservas sin recargar la pagina.
- `servicios/pedidos.php`: valida y guarda pedidos con transacciones.
- `servicios/reservas.php`: valida y guarda reservas.
- `administracion/seguridad.php`: controla la sesion del administrador.
- `administracion/login.php`: login del panel interno.
- `base_de_datos/esquema.sql`: crea toda la base de datos y carga datos iniciales.
- `recursos/css/estilos.css`: contiene el diseno visual de la web, carta, formularios, footer y administracion.

## Notas para la defensa

- El proyecto separa frontend, backend, administracion, servicios y base de datos.
- El cliente no ve enlaces directos al panel de administracion como parte normal de la navegacion publica.
- El panel interno esta protegido con sesion.
- Los precios no se confian al navegador: PHP consulta productos y precios otra vez en MySQL.
- El total visible en el carrito tambien se recalcula en PHP antes de guardar.
- El pago es simulado y no guarda datos sensibles de tarjeta.
- Las reservas no tienen pago previo porque solo bloquean una mesa y quedan pendientes de confirmacion.
- Los horarios se validan dos veces: en JavaScript para ayudar al usuario y en PHP para proteger el sistema.
- El codigo esta comentado para facilitar su explicacion en la presentacion.

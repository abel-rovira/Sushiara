-- Crea la base de datos del proyecto si todavia no existe.
CREATE DATABASE IF NOT EXISTS sushiara
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Selecciona la base de datos para que todas las tablas se creen dentro.
USE sushiara;

-- Borramos tablas antiguas para poder reimportar el proyecto desde cero.
DROP TABLE IF EXISTS detalles_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS reservas;
DROP TABLE IF EXISTS administradores;
DROP TABLE IF EXISTS productos;

-- Tabla principal de productos de la carta.
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  descripcion VARCHAR(255) NOT NULL,
  categoria VARCHAR(60) NOT NULL,
  precio DECIMAL(8,2) NOT NULL,
  imagen VARCHAR(255) NOT NULL,
  etiqueta VARCHAR(40) NULL,
  picante TINYINT(1) NOT NULL DEFAULT 0,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de administradores: permite iniciar sesion en el panel interno.
CREATE TABLE administradores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(80) NOT NULL UNIQUE,
  clave_hash VARCHAR(255) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de pedidos: guarda datos del cliente, entrega, pago y total.
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_cliente VARCHAR(120) NOT NULL,
  telefono_cliente VARCHAR(30) NOT NULL,
  direccion_cliente VARCHAR(255) NOT NULL,
  tipo_entrega ENUM('domicilio','recogida') NOT NULL DEFAULT 'domicilio',
  fecha_entrega DATE NULL,
  hora_entrega TIME NULL,
  metodo_pago ENUM('tarjeta','efectivo','bizum') NOT NULL DEFAULT 'tarjeta',
  -- Marca que el pago pertenece a una simulacion del proyecto, no a una pasarela real.
  pago_simulado TINYINT(1) NOT NULL DEFAULT 1,
  -- Guarda solo una referencia segura: nunca numeros completos de tarjeta.
  referencia_pago VARCHAR(80) NULL,
  notas TEXT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  gastos_envio DECIMAL(8,2) NOT NULL DEFAULT 0,
  total DECIMAL(10,2) NOT NULL,
  estado ENUM('pendiente','preparando','listo','enviado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de lineas de pedido: guarda cada producto incluido en un pedido.
CREATE TABLE detalles_pedido (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  producto_id INT NOT NULL,
  nombre_producto VARCHAR(120) NOT NULL,
  precio_unitario DECIMAL(8,2) NOT NULL,
  cantidad INT NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Tabla de reservas de mesa en el restaurante.
CREATE TABLE reservas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_cliente VARCHAR(120) NOT NULL,
  telefono_cliente VARCHAR(30) NOT NULL,
  email_cliente VARCHAR(120) NULL,
  fecha_reserva DATE NOT NULL,
  hora_reserva TIME NOT NULL,
  personas INT NOT NULL,
  zona ENUM('sala','terraza','barra') NOT NULL DEFAULT 'sala',
  ocasion VARCHAR(80) NULL,
  notas TEXT NULL,
  estado ENUM('pendiente','confirmada','cancelada') NOT NULL DEFAULT 'pendiente',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Productos iniciales de la carta. Cada fila es un producto visible en pedido.php.
INSERT INTO productos (nombre, descripcion, categoria, precio, imagen, etiqueta, picante) VALUES
('Combo Sakura 24 piezas', 'Makis de salmon, nigiris, uramakis y piezas del chef para compartir.', 'Promociones', 24.90, 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=720&q=80', 'Popular', 0),
('Menu Duo 32 piezas', 'Seleccion variada con rolls crujientes, salmon, aguacate y gyozas.', 'Promociones', 31.90, 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?auto=format&fit=crop&w=720&q=80', 'Oferta', 0),
('Festival Sushiara 48 piezas', 'Bandeja grande con rolls especiales, nigiris, makis y postre incluido.', 'Promociones', 48.50, 'https://images.unsplash.com/photo-1553621042-f6e147245754?auto=format&fit=crop&w=720&q=80', 'Nuevo', 0),
('Combo Salmon Lovers', 'Sake maki, nigiri salmon, uramaki salmon y salsa ponzu citrica.', 'Combos', 19.90, 'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Combo Dragon', 'Uramakis dragon, ebi tempura, aguacate y topping teriyaki.', 'Combos', 21.50, 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?auto=format&fit=crop&w=720&q=80', 'Chef', 0),
('Combo Veggie', 'Makis de pepino, edamame, aguacate, mochi y salsa de sesamo.', 'Combos', 16.90, 'https://images.unsplash.com/photo-1563612116625-3012372fccce?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Gyozas de pollo', 'Empanadillas japonesas doradas con salsa ponzu casera.', 'Entrantes', 5.90, 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?auto=format&fit=crop&w=720&q=80', 'Top', 0),
('Edamame con sal marina', 'Vainas de soja calientes con sesamo tostado.', 'Entrantes', 4.50, 'https://images.unsplash.com/photo-1625937751876-4515cd8e78bd?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Ebi tempura', 'Langostinos crujientes con mayonesa japonesa suave.', 'Entrantes', 7.90, 'https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Takoyaki', 'Bolitas japonesas con salsa dulce, mayo y copos de bonito.', 'Entrantes', 6.90, 'https://images.unsplash.com/photo-1612929633738-8fe44f7ec841?auto=format&fit=crop&w=720&q=80', 'Nuevo', 0),
('Maki salmon', 'Roll clasico con salmon fresco y arroz sushi.', 'Rolls Clasicos', 7.50, 'https://images.unsplash.com/photo-1617196034183-421b4917c92d?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Maki atun', 'Roll fino de atun rojo, alga nori y arroz avinagrado.', 'Rolls Clasicos', 8.20, 'https://images.unsplash.com/photo-1617196035154-1e7e6e28b0db?auto=format&fit=crop&w=720&q=80', NULL, 0),
('California roll', 'Kanikama, aguacate, pepino y sesamo por fuera.', 'Rolls Clasicos', 8.50, 'https://images.unsplash.com/photo-1611143669185-af224c5e3252?auto=format&fit=crop&w=720&q=80', 'Clasico', 0),
('Philadelphia roll', 'Salmon, queso crema, aguacate y cebollino.', 'Rolls Clasicos', 8.90, 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Uramaki Dragon', 'Langostino tempura, aguacate y salsa teriyaki.', 'Rolls Especiales', 10.90, 'https://images.unsplash.com/photo-1553621042-f6e147245754?auto=format&fit=crop&w=720&q=80', 'Chef', 0),
('Spicy Tuna Roll', 'Atun picante, pepino, mayo japonesa y shichimi.', 'Rolls Especiales', 11.50, 'https://images.unsplash.com/photo-1617196035154-1e7e6e28b0db?auto=format&fit=crop&w=720&q=80', 'Picante', 1),
('Sake Flame Roll', 'Salmon flambeado, queso crema, aguacate y salsa kabayaki.', 'Rolls Especiales', 12.50, 'https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?auto=format&fit=crop&w=720&q=80', 'Flambeado', 0),
('Crunchy Ebi Roll', 'Ebi tempura, panko, cebollino y mayonesa spicy.', 'Rolls Especiales', 11.90, 'https://images.unsplash.com/photo-1617196034183-421b4917c92d?auto=format&fit=crop&w=720&q=80', NULL, 1),
('Nigiri mixto', '6 nigiris variados de salmon, atun y langostino.', 'Nigiris', 11.50, 'https://images.unsplash.com/photo-1583623025817-d180a2221d0a?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Nigiri salmon', '2 piezas de arroz sushi con salmon fresco.', 'Nigiris', 4.90, 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Nigiri atun', '2 piezas con atun rojo y toque de wasabi.', 'Nigiris', 5.50, 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Gohan salmon', 'Bol de arroz, salmon, aguacate, edamame, pepino y sriracha mayo.', 'Gohan', 10.90, 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=720&q=80', 'Completo', 1),
('Gohan crispy chicken', 'Arroz sushi, pollo crujiente, maiz, aguacate y salsa teriyaki.', 'Gohan', 9.90, 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Gohan veggie', 'Arroz, tofu, edamame, zanahoria, aguacate y sesamo.', 'Gohan', 8.90, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Dorayaki chocolate', 'Bizcochito japones relleno de crema de cacao.', 'Postres', 4.20, 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?auto=format&fit=crop&w=720&q=80', 'Dulce', 0),
('Te verde frio', 'Bebida suave de te verde con limon.', 'Bebidas', 2.80, 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Ramune lima', 'Refresco japones con bola de cristal.', 'Bebidas', 3.20, 'https://commons.wikimedia.org/wiki/Special:FilePath/Ramune_original_flavor_bottle.JPG', 'Japon', 0),
('Agua mineral', 'Botella de agua fria de 500 ml.', 'Bebidas', 1.80, 'https://images.unsplash.com/photo-1616118132534-381148898bb4?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Sashimi salmon', '6 cortes de salmon fresco con soja y wasabi.', 'Sashimi', 10.90, 'https://images.unsplash.com/photo-1534482421-64566f976cfa?auto=format&fit=crop&w=720&q=80', 'Fresco', 0),
('Sashimi atun rojo', '6 cortes de atun rojo con corte limpio y textura suave.', 'Sashimi', 12.90, 'https://images.unsplash.com/photo-1617196034183-421b4917c92d?auto=format&fit=crop&w=720&q=80', 'Premium', 0),
('Sashimi mixto', '12 cortes variados de salmon, atun y pescado blanco.', 'Sashimi', 18.90, 'https://images.unsplash.com/photo-1583623025817-d180a2221d0a?auto=format&fit=crop&w=720&q=80', 'Chef', 0),
('Tartar de salmon', 'Salmon picado, aguacate, soja, sesamo y toque citrico.', 'Sashimi', 11.90, 'https://images.unsplash.com/photo-1607301406259-dfb186e15de8?auto=format&fit=crop&w=720&q=80', 'Nuevo', 0),
('Ramen tonkotsu', 'Caldo cremoso, fideos, chashu, huevo marinado, maiz y nori.', 'Ramen y Sopas', 12.90, 'https://images.unsplash.com/photo-1557872943-16a5ac26437e?auto=format&fit=crop&w=720&q=80', 'Top', 0),
('Ramen miso picante', 'Caldo miso, carne, verduras, huevo y aceite picante japones.', 'Ramen y Sopas', 12.50, 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=720&q=80', 'Picante', 1),
('Ramen shoyu', 'Caldo de soja, fideos finos, pollo, huevo, cebolleta y naruto.', 'Ramen y Sopas', 11.90, 'https://images.unsplash.com/photo-1617093727343-374698b1b08d?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Sopa miso', 'Sopa japonesa con tofu, alga wakame y cebolleta.', 'Ramen y Sopas', 3.90, 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Sopa udon tempura', 'Caldo suave con fideos udon, langostino tempura y verduras.', 'Ramen y Sopas', 10.90, 'https://images.unsplash.com/photo-1618841557871-b4664fbf0cb3?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Yakisoba pollo', 'Fideos salteados con pollo, verduras y salsa yakisoba.', 'Wok y Noodles', 9.90, 'https://images.unsplash.com/photo-1525755662778-989d0524087e?auto=format&fit=crop&w=720&q=80', 'Clasico', 0),
('Yakisoba langostino', 'Fideos salteados con langostinos, verduras frescas y sesamo.', 'Wok y Noodles', 11.50, 'https://images.unsplash.com/photo-1552611052-33e04de081de?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Udon teriyaki', 'Fideos udon salteados con pollo, setas, cebolla y salsa teriyaki.', 'Wok y Noodles', 10.90, 'https://images.unsplash.com/photo-1612927601601-6638404737ce?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Arroz frito japones', 'Arroz salteado con huevo, verduras, soja y pollo.', 'Wok y Noodles', 8.90, 'https://images.unsplash.com/photo-1512058564366-18510be2db19?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Katsu curry', 'Pollo empanado japones con arroz y curry suave.', 'Wok y Noodles', 11.90, 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&w=720&q=80', 'Completo', 0),
('Cheesecake de te matcha', 'Tarta cremosa de matcha con base crujiente.', 'Postres', 5.20, 'https://images.unsplash.com/photo-1627308595229-7830a5c91f9f?auto=format&fit=crop&w=720&q=80', 'Matcha', 0),
('Taiyaki crema', 'Dulce japones con forma de pez relleno de crema.', 'Postres', 4.80, 'https://images.unsplash.com/photo-1590080875515-8a3a8dc5735e?auto=format&fit=crop&w=720&q=80', 'Japon', 0),
('Helado de sesamo negro', 'Helado artesano de sesamo negro con textura cremosa.', 'Postres', 4.90, 'https://images.unsplash.com/photo-1488900128323-21503983a07e?auto=format&fit=crop&w=720&q=80', NULL, 0),
('Mochi cheesecake', 'Mochi relleno de crema cheesecake y frutos rojos.', 'Postres', 5.50, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=720&q=80', 'Nuevo', 0),
('Coca-Cola', 'Lata fria de Coca-Cola original.', 'Bebidas', 2.40, 'https://commons.wikimedia.org/wiki/Special:FilePath/Coca-Cola_330ml_can.jpg', NULL, 0),
('Cerveza Asahi', 'Cerveza japonesa Asahi bien fria.', 'Bebidas', 3.80, 'https://commons.wikimedia.org/wiki/Special:FilePath/AsahiSuperDry.jpg', 'Japon', 0),
('Sake frio', 'Copa de sake japones servido frio.', 'Bebidas', 4.50, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=720&q=80', 'Sake', 0),
('Limonada yuzu', 'Limonada japonesa con yuzu, hielo y hierbabuena.', 'Bebidas', 3.50, 'https://images.unsplash.com/photo-1523371054106-bbf80586c38c?auto=format&fit=crop&w=720&q=80', 'Yuzu', 0),
('Te matcha latte frio', 'Matcha con leche, hielo y punto dulce suave.', 'Bebidas', 4.20, 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?auto=format&fit=crop&w=720&q=80', 'Matcha', 0),
('Sprite', 'Refresco de lima-limon frio en botella.', 'Bebidas', 2.40, 'https://commons.wikimedia.org/wiki/Special:FilePath/Sprite_bottle.JPG', NULL, 0),
('7UP', 'Refresco de lima-limon frio en lata.', 'Bebidas', 2.40, 'https://commons.wikimedia.org/wiki/Special:FilePath/Can_of_Seven_Up.jpg', NULL, 0),
('Fanta naranja', 'Refresco de naranja frio en lata.', 'Bebidas', 2.40, 'https://commons.wikimedia.org/wiki/Special:FilePath/Fanta-Orange-Can-330ml_84177_(7116950883).jpg', NULL, 0),
('Nestea limon', 'Te frio con limon en botella.', 'Bebidas', 2.60, 'https://commons.wikimedia.org/wiki/Special:FilePath/Nestea_bottle.jpg', NULL, 0),
('Tonica', 'Tonica fria con burbuja fina.', 'Bebidas', 2.50, 'https://commons.wikimedia.org/wiki/Special:FilePath/Schweppes_Indian_Tonic_Water_(front).jpg', NULL, 0),
('Zumo de mango', 'Zumo frio de mango tropical.', 'Bebidas', 3.20, 'https://images.unsplash.com/photo-1546173159-315724a31696?auto=format&fit=crop&w=720&q=80', 'Tropical', 0);

-- Usuario administrador inicial.
-- Usuario: admin
-- Contrasena: shushiara123
INSERT INTO administradores (usuario, clave_hash) VALUES
('admin', '$2y$10$kNQhUe06CY9JvrZzP.69IumZPqlzVO0fLrhIKATYeoX2oavSlWA8W');

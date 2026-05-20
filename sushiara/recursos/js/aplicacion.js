// Este Map guarda el carrito en memoria mientras el usuario esta en la pagina.
// La clave es el id del producto y el valor es el producto con su cantidad.
const carrito = new Map();

// Formateador para mostrar precios en euros con formato espanol.
const formatoDinero = new Intl.NumberFormat('es-ES', {
  style: 'currency',
  currency: 'EUR',
});

// Elementos del DOM relacionados con el carrito y el formulario de pedido.
const cartItems = document.querySelector('#cartItems');
const cartCount = document.querySelector('#cartCount');
const cartSubtotal = document.querySelector('#cartSubtotal');
const cartDelivery = document.querySelector('#cartDelivery');
const cartTotal = document.querySelector('#cartTotal');
const orderForm = document.querySelector('#orderForm');
const formMessage = document.querySelector('#formMessage');
const metodoPago = document.querySelector('#metodo_pago');
const fechaEntrega = document.querySelector('#fecha_entrega');
const horaEntrega = document.querySelector('#hora_entrega');

// Elementos del DOM relacionados con filtros, busqueda y reservas rapidas.
const buscadorProductos = document.querySelector('#buscadorProductos');
const reservaRapida = document.querySelector('#reservaRapida');
const reservaMensaje = document.querySelector('#reservaMensaje');

// Si el script se ejecuta dentro de /paginas/, las rutas a servicios deben subir un nivel.
const rutaBase = window.location.pathname.includes('/paginas/') ? '../' : '';

// Importe fijo del desplazamiento cuando el cliente elige pedido a domicilio.
const COSTE_ENVIO_DOMICILIO = 5;

// Horarios reales por tipo de dia. Viernes y sabado se atiende hasta las 00:00,
// por eso la ultima franja seleccionable es 23:30.
const horariosRestaurante = {
  entreSemana: ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00'],
  viernesSabado: ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'],
  domingo: ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'],
};

// Devuelve la fecha actual en formato YYYY-MM-DD para comparar con inputs date.
function obtenerFechaHoy() {
  return new Date().toISOString().split('T')[0];
}

// Devuelve las horas disponibles segun el dia de la semana seleccionado.
function obtenerHorasPorFecha(fecha) {
  if (!fecha) {
    // Si aun no hay fecha, devolvemos todas las horas posibles para no bloquear el selector.
    return Object.values(horariosRestaurante).flat();
  }

  const diaSemana = new Date(`${fecha}T12:00:00`).getDay();

  if (diaSemana === 0) {
    return horariosRestaurante.domingo;
  }

  if (diaSemana === 5 || diaSemana === 6) {
    return horariosRestaurante.viernesSabado;
  }

  return horariosRestaurante.entreSemana;
}

// Activa solo los campos necesarios segun el metodo de pago elegido.
function actualizarPagoSimulado() {
  const metodoActual = metodoPago?.value || 'tarjeta';

  document.querySelectorAll('.pago-opcion').forEach((bloque) => {
    const activo = bloque.dataset.pago === metodoActual;
    bloque.hidden = !activo;

    // Los campos ocultos no se obligan para que el formulario cambie de metodo sin bloquearse.
    bloque.querySelectorAll('input').forEach((input) => {
      input.required = activo && metodoActual !== 'efectivo';
    });
  });
}

// Evita fechas anteriores desde el navegador y deja preparada la validacion antes de enviar.
function configurarFechas() {
  const hoy = obtenerFechaHoy();

  if (fechaEntrega) {
    fechaEntrega.min = hoy;
    actualizarHorasDisponibles();
  }
}

// Comprueba que la hora elegida pertenece a los turnos de comida o cena.
function validarHoraRestaurante(campoHora) {
  const hora = campoHora?.value || '';

  return obtenerHorasPorFecha(fechaEntrega?.value || '').includes(hora);
}

// Desactiva horas que ya han pasado cuando el cliente programa para hoy.
function actualizarHorasDisponibles() {
  if (!fechaEntrega || !horaEntrega) {
    return;
  }

  const ahora = new Date();
  const minutosAhora = ahora.getHours() * 60 + ahora.getMinutes();
  const esHoy = fechaEntrega.value === obtenerFechaHoy();
  const horasPermitidas = obtenerHorasPorFecha(fechaEntrega.value);

  horaEntrega.querySelectorAll('option').forEach((option) => {
    if (option.value === '') {
      option.disabled = false;
      return;
    }

    const [hora, minutos] = option.value.split(':').map(Number);
    const minutosOpcion = hora * 60 + minutos;
    option.disabled = !horasPermitidas.includes(option.value) || (esHoy && minutosOpcion <= minutosAhora);
  });

  // Si la hora seleccionada queda desactivada, obligamos a escoger otra.
  if (horaEntrega.selectedOptions[0]?.disabled) {
    horaEntrega.value = '';
  }
}

// Calcula subtotal, gastos de envio, total y numero de unidades del carrito.
function calcularResumen() {
  let subtotal = 0;
  let unidades = 0;

  // Recorremos todos los articulos del carrito para sumar precios y cantidades.
  carrito.forEach((articulo) => {
    subtotal += articulo.precio * articulo.cantidad;
    unidades += articulo.cantidad;
  });

  // Lee si el usuario quiere domicilio o recogida. Domicilio tiene coste de envio fijo.
  const tipoEntrega = document.querySelector('input[name="tipo_entrega"]:checked')?.value || 'domicilio';
  const envio = subtotal > 0 && tipoEntrega === 'domicilio' ? COSTE_ENVIO_DOMICILIO : 0;

  // Devolvemos un objeto con todos los datos calculados.
  return {
    subtotal,
    envio,
    total: subtotal + envio,
    unidades,
  };
}

// Redibuja el carrito cada vez que cambia una cantidad o se anade un producto.
function pintarCarrito() {
  const resumen = calcularResumen();

  // Limpiamos la lista antes de volver a pintarla.
  cartItems.innerHTML = '';

  // Actualizamos los contadores y precios visibles.
  cartCount.textContent = String(resumen.unidades);
  cartSubtotal.textContent = formatoDinero.format(resumen.subtotal);
  cartDelivery.textContent = formatoDinero.format(resumen.envio);
  cartTotal.textContent = formatoDinero.format(resumen.total);

  // Si no hay articulos, mostramos un mensaje sencillo.
  if (carrito.size === 0) {
    cartItems.innerHTML = '<p class="empty-cart" data-i18n="carritoVacio">El carrito esta vacio.</p>';
    if (typeof aplicarIdioma === 'function') {
      aplicarIdioma(localStorage.getItem('shushiara_idioma') || 'es');
    }
    return;
  }

  // Creamos una fila visual para cada articulo del carrito.
  carrito.forEach((articulo) => {
    const fila = document.createElement('div');
    fila.className = 'cart-row';
    fila.innerHTML = `
      <div class="cart-row-info">
        <strong>${articulo.nombre}</strong>
        <span>${formatoDinero.format(articulo.precio)} x ${articulo.cantidad}</span>
      </div>
      <div class="quantity-controls">
        <button type="button" data-action="decrease" data-id="${articulo.id}" aria-label="Restar ${articulo.nombre}">-</button>
        <span>${articulo.cantidad}</span>
        <button type="button" data-action="increase" data-id="${articulo.id}" aria-label="Sumar ${articulo.nombre}">+</button>
      </div>
    `;
    cartItems.appendChild(fila);
  });
}

// Anade un producto al carrito o aumenta su cantidad si ya existe.
function anadirAlCarrito(producto) {
  const actual = carrito.get(producto.id);

  if (actual) {
    actual.cantidad += 1;
  } else {
    carrito.set(producto.id, { ...producto, cantidad: 1 });
  }

  pintarCarrito();
}

// Filtra productos por categoria activa y por texto escrito en el buscador.
function filtrarProductos() {
  const categoriaActiva = document.querySelector('.categoria-btn.active')?.dataset.category || 'all';
  const busqueda = (buscadorProductos?.value || '').trim().toLowerCase();

  // Ocultamos cada producto si no coincide con categoria o busqueda.
  document.querySelectorAll('.producto-linea').forEach((producto) => {
    const coincideCategoria = categoriaActiva === 'all' || producto.dataset.category === categoriaActiva;
    const coincideBusqueda = producto.dataset.search.includes(busqueda);
    producto.hidden = !coincideCategoria || !coincideBusqueda;
  });

  // Ocultamos grupos completos si todos sus productos estan ocultos.
  document.querySelectorAll('.grupo-categoria').forEach((grupo) => {
    const visibles = Array.from(grupo.querySelectorAll('.producto-linea')).some((producto) => !producto.hidden);
    grupo.hidden = !visibles;
  });
}

// Botones "Anadir": pasan los datos HTML del producto al carrito.
document.querySelectorAll('.add-btn').forEach((button) => {
  button.addEventListener('click', () => {
    anadirAlCarrito({
      id: Number(button.dataset.id),
      nombre: button.dataset.name,
      precio: Number(button.dataset.price),
    });

    // Pequena confirmacion visual para que el usuario sepa que se anadio.
    button.textContent = 'Anadido';
    setTimeout(() => {
      button.textContent = 'Anadir';
    }, 700);
  });
});

// Botones de categoria: marcan la categoria activa y aplican el filtro.
document.querySelectorAll('.categoria-btn').forEach((button) => {
  button.addEventListener('click', () => {
    document.querySelectorAll('.categoria-btn').forEach((item) => item.classList.remove('active'));
    button.classList.add('active');
    filtrarProductos();
  });
});

// Cada vez que se escribe en el buscador, se vuelven a filtrar productos.
buscadorProductos?.addEventListener('input', filtrarProductos);

// Cuando el cliente cambia tarjeta/Bizum/efectivo, se muestran sus campos.
metodoPago?.addEventListener('change', actualizarPagoSimulado);
fechaEntrega?.addEventListener('change', actualizarHorasDisponibles);

// Delegacion de eventos para los botones + y - dentro del carrito.
cartItems.addEventListener('click', (event) => {
  const button = event.target.closest('button[data-action]');

  if (!button) {
    return;
  }

  const id = Number(button.dataset.id);
  const articulo = carrito.get(id);

  if (!articulo) {
    return;
  }

  // Suma una unidad.
  if (button.dataset.action === 'increase') {
    articulo.cantidad += 1;
  }

  // Resta una unidad y elimina el articulo si llega a cero.
  if (button.dataset.action === 'decrease') {
    articulo.cantidad -= 1;

    if (articulo.cantidad <= 0) {
      carrito.delete(id);
    }
  }

  pintarCarrito();
});

// Si cambia domicilio/recogida, recalculamos el envio.
document.querySelectorAll('input[name="tipo_entrega"]').forEach((input) => {
  input.addEventListener('change', pintarCarrito);
});

// Envio del formulario de pedido al servicio PHP.
orderForm.addEventListener('submit', async (event) => {
  event.preventDefault();
  formMessage.textContent = '';
  formMessage.className = 'form-message mt-3';

  // No permitimos enviar pedidos vacios.
  if (carrito.size === 0) {
    formMessage.textContent = 'Anade algun producto antes de enviar el pedido.';
    formMessage.classList.add('error');
    return;
  }

  // Evitamos enviar fechas anteriores aunque el navegador no respete el atributo min.
  if (fechaEntrega?.value && fechaEntrega.value < obtenerFechaHoy()) {
    formMessage.textContent = 'La fecha de entrega no puede ser anterior a hoy.';
    formMessage.classList.add('error');
    return;
  }

  // Para elegir una hora concreta tambien hace falta indicar fecha.
  if (horaEntrega?.value && !fechaEntrega?.value) {
    formMessage.textContent = 'Selecciona tambien la fecha de entrega para programar una hora.';
    formMessage.classList.add('error');
    return;
  }

  // El pedido solo puede estar dentro del horario real del restaurante.
  if (!validarHoraRestaurante(horaEntrega)) {
    formMessage.textContent = 'Selecciona una hora disponible segun el dia elegido.';
    formMessage.classList.add('error');
    return;
  }

  // Convertimos los campos del formulario en objeto. FormData incluye tambien los campos
  // del pago simulado que esten activos en ese momento.
  const formData = new FormData(orderForm);
  const payload = Object.fromEntries(formData.entries());

  // Anexamos los articulos del carrito para que PHP pueda guardarlos.
  payload.articulos = Array.from(carrito.values()).map((articulo) => ({
    id: articulo.id,
    cantidad: articulo.cantidad,
  }));

  try {
    // Enviamos el pedido como JSON a servicios/pedidos.php.
    const response = await fetch(`${rutaBase}servicios/pedidos.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(payload),
    });
    const result = await response.json();

    // Si PHP responde con error, lo mostramos al usuario.
    if (!response.ok || !result.ok) {
      throw new Error(result.message || 'No se pudo enviar el pedido.');
    }

    // Si todo va bien, limpiamos carrito y formulario.
    carrito.clear();
    orderForm.reset();
    document.querySelector('#domicilio').checked = true;
    actualizarPagoSimulado();
    pintarCarrito();
    formMessage.textContent = `Pedido #${result.order_id} recibido. Total: ${result.total}. ${result.pago || ''}`;
    formMessage.classList.add('success');
  } catch (error) {
    formMessage.textContent = error.message;
    formMessage.classList.add('error');
  }
});

// Envio de reserva rapida si existe ese formulario en la pagina.
reservaRapida?.addEventListener('submit', async (event) => {
  event.preventDefault();
  reservaMensaje.textContent = '';
  reservaMensaje.className = 'form-message mt-3';

  const payload = Object.fromEntries(new FormData(reservaRapida).entries());

  try {
    // Enviamos la reserva al servicio PHP correspondiente.
    const response = await fetch(`${rutaBase}servicios/reservas.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(payload),
    });
    const result = await response.json();

    if (!response.ok || !result.ok) {
      throw new Error(result.message || 'No se pudo guardar la reserva.');
    }

    reservaRapida.reset();
    reservaMensaje.textContent = `Reserva #${result.reserva_id} recibida. Te llamaremos para confirmar.`;
    reservaMensaje.classList.add('success');
  } catch (error) {
    reservaMensaje.textContent = error.message;
    reservaMensaje.classList.add('error');
  }
});

// Pintado inicial para que el carrito aparezca bien al cargar la pagina.
configurarFechas();
actualizarPagoSimulado();
pintarCarrito();

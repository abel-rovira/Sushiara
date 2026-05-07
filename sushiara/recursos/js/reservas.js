// Seleccionamos el formulario de reservas y el mensaje donde mostramos errores/exitos.
const reservaRapida = document.querySelector('#reservaRapida');
const reservaMensaje = document.querySelector('#reservaMensaje');
const fechaReserva = document.querySelector('#fecha_reserva');
const horaReserva = document.querySelector('#hora_reserva');

// Horarios reales por tipo de dia. Viernes y sabado se atiende hasta las 00:00,
// por eso la ultima franja seleccionable es 23:30.
const horariosRestaurante = {
  entreSemana: ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00'],
  viernesSabado: ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30'],
  domingo: ['13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30'],
};

// Fecha actual en formato compatible con input date.
function obtenerFechaHoy() {
  return new Date().toISOString().split('T')[0];
}

// Devuelve las horas disponibles segun la fecha elegida.
function obtenerHorasPorFecha(fecha) {
  if (!fecha) {
    // Antes de elegir fecha dejamos el selector preparado con todas las franjas posibles.
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

// El calendario del navegador no debe permitir dias anteriores.
if (fechaReserva) {
  fechaReserva.min = obtenerFechaHoy();
}

// Desactiva horas que ya han pasado cuando la reserva es para hoy.
function actualizarHorasDisponibles() {
  if (!fechaReserva || !horaReserva) {
    return;
  }

  const ahora = new Date();
  const minutosAhora = ahora.getHours() * 60 + ahora.getMinutes();
  const esHoy = fechaReserva.value === obtenerFechaHoy();
  const horasPermitidas = obtenerHorasPorFecha(fechaReserva.value);

  horaReserva.querySelectorAll('option').forEach((option) => {
    if (option.value === '') {
      option.disabled = false;
      return;
    }

    const [hora, minutos] = option.value.split(':').map(Number);
    const minutosOpcion = hora * 60 + minutos;
    option.disabled = !horasPermitidas.includes(option.value) || (esHoy && minutosOpcion <= minutosAhora);
  });

  // Si el usuario habia elegido una hora que ya no vale para esa fecha, se limpia.
  if (horaReserva.selectedOptions[0]?.disabled) {
    horaReserva.value = '';
  }
}

fechaReserva?.addEventListener('change', actualizarHorasDisponibles);
actualizarHorasDisponibles();

// Escuchamos el envio del formulario para gestionarlo con JavaScript sin recargar la pagina.
reservaRapida?.addEventListener('submit', async (event) => {
  event.preventDefault();

  // Limpiamos el mensaje anterior antes de enviar.
  reservaMensaje.textContent = '';
  reservaMensaje.className = 'form-message mt-3';

  // Convertimos todos los campos del formulario en un objeto normal.
  const payload = Object.fromEntries(new FormData(reservaRapida).entries());

  // Validacion de fecha pasada tambien en JavaScript para dar respuesta inmediata.
  if (fechaReserva?.value && fechaReserva.value < obtenerFechaHoy()) {
    reservaMensaje.textContent = 'La fecha de reserva no puede ser anterior a hoy.';
    reservaMensaje.classList.add('error');
    return;
  }

  // La reserva solo se puede hacer en las horas abiertas del restaurante.
  if (!obtenerHorasPorFecha(fechaReserva?.value || '').includes(horaReserva?.value || '')) {
    reservaMensaje.textContent = 'Selecciona una hora disponible segun el dia elegido.';
    reservaMensaje.classList.add('error');
    return;
  }

  try {
    // Enviamos la reserva al servicio PHP que guarda en la tabla reservas.
    const response = await fetch('../servicios/reservas.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(payload),
    });
    const result = await response.json();

    // Si PHP devuelve error, lanzamos una excepcion para mostrarla abajo.
    if (!response.ok || !result.ok) {
      throw new Error(result.message || 'No se pudo guardar la reserva.');
    }

    // Si todo ha ido bien, limpiamos el formulario y mostramos confirmacion.
    reservaRapida.reset();
    reservaMensaje.textContent = `Reserva #${result.reserva_id} recibida. Te llamaremos para confirmar.`;
    reservaMensaje.classList.add('success');
  } catch (error) {
    reservaMensaje.textContent = error.message;
    reservaMensaje.classList.add('error');
  }
});

document.addEventListener("DOMContentLoaded", function () {
    const carnetMiembro = document.getElementById("carnet_miembro");
    const tipoServicio = document.getElementById("tipo_servicio");
    const prestamoSelect = document.getElementById("control_servicio_id");
    const btnRegistrar = document.getElementById("btn-registrar-devolucion");

    function cargarPrestamos() {
        const carnet = carnetMiembro.value;
        const tipo = tipoServicio.value;
        const url = btnRegistrar.getAttribute("data-url");

        if (!carnet || !tipo) {
            prestamoSelect.innerHTML = '<option value="">Seleccionar</option>';
            return;
        }

        fetch(url, { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ carnet: carnet, tipo_servicio: tipo })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            prestamoSelect.innerHTML = '<option value="">Seleccionar</option>';

            if (data.length > 0) {
                data.forEach(prestamo => {
                    let detalle = prestamo.libro 
                        ? `Libro: ${prestamo.libro.signatura_topografica}` 
                        : prestamo.computadora 
                            ? `PC: ${prestamo.computadora.codigo_computadora}` 
                            : 'Sin detalles';

                    prestamoSelect.innerHTML += `<option value="${prestamo.id}">${detalle}</option>`;
                });
            } else {
                prestamoSelect.innerHTML = '<option value="">No hay préstamos disponibles</option>';
            }
        })
        .catch(error => {
            console.error('No hay préstamos disponibles', error);
            prestamoSelect.innerHTML = '<option value="">No hay préstamos disponibles</option>';
        });
    }

    carnetMiembro.addEventListener("change", cargarPrestamos);
    tipoServicio.addEventListener("change", cargarPrestamos);
});
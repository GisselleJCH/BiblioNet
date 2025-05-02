document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscarservicios");
    const tablaServicios = document.getElementById("tabla-servicios");

    inputBuscar.addEventListener("keyup", function () {
        const filtro = inputBuscar.value.toLowerCase();
        const filas = tablaServicios.getElementsByTagName("tr");

        for (let i = 0; i < filas.length; i++) {
            const columnas = filas[i].getElementsByTagName("td"); // Todas las columnas de la fila
            let mostrarFila = false;

            // Verificar cada columna relevante (carnet, sala de atención, tipo de servicio, código de computadora, signatura topográfica)
            for (let j = 0; j < columnas.length; j++) {
                const textoColumna = columnas[j].textContent || columnas[j].innerText;
                if (textoColumna.toLowerCase().indexOf(filtro) > -1) {
                    mostrarFila = true; // Si coincide, mostrar la fila
                    break;
                }
            }

            filas[i].style.display = mostrarFila ? "" : "none"; // Mostrar u ocultar la fila
        }
    });

    // Confirmación antes de eliminar un registro
    const botonesEliminar = document.querySelectorAll(".btn-eliminar");
    botonesEliminar.forEach(function (boton) {
        boton.addEventListener("click", function (evento) {
            const confirmacion = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (!confirmacion) {
                evento.preventDefault(); // Cancelar la acción de eliminación
            }
        });
    });
});
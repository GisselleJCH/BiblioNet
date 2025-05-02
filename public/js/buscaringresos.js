document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscaringresos");
    const tablaIngresos = document.getElementById("tabla-ingresos");

    // Filtrar registros en la tabla
    inputBuscar.addEventListener("keyup", function () {
        const filtro = inputBuscar.value.toLowerCase();
        const filas = tablaIngresos.getElementsByTagName("tr");

        for (let i = 0; i < filas.length; i++) {
            const columnas = filas[i].getElementsByTagName("td"); // Todas las columnas de la fila
            let mostrarFila = false;

            // Verificar cada columna relevante (carnet, área del conocimiento, carrera, sede)
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
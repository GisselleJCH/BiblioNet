document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscaringresos");
    const tablaIngresos = document.getElementById("tabla-ingresos");

    // Filtrar registros en la tabla
    inputBuscar.addEventListener("keyup", function () {
        const filtro = inputBuscar.value.toLowerCase();
        const filas = tablaIngresos.getElementsByTagName("tr");

        for (let i = 0; i < filas.length; i++) {
            const columnaCarnet = filas[i].getElementsByTagName("td")[0]; // Primera columna (Carnet)
            if (columnaCarnet) {
                const textoCarnet = columnaCarnet.textContent || columnaCarnet.innerText;
                if (textoCarnet.toLowerCase().indexOf(filtro) > -1) {
                    filas[i].style.display = ""; // Mostrar fila
                } else {
                    filas[i].style.display = "none"; // Ocultar fila
                }
            }
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
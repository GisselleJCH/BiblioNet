document.addEventListener("DOMContentLoaded", function () {
    const inputBuscar = document.getElementById("buscardevoluciones");
    const tablaDevoluciones = document.getElementById("tabla-devoluciones");

    inputBuscar.addEventListener("keyup", function () {
        const filtro = inputBuscar.value.toLowerCase();
        const filas = tablaDevoluciones.getElementsByTagName("tr");

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
});
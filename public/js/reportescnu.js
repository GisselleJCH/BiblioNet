document.addEventListener("DOMContentLoaded", function () {
    const tablaReportes = document.getElementById("tabla-reportes");
    const fechaDesde = document.getElementById("fecha-desde");
    const fechaHasta = document.getElementById("fecha-hasta");
    const filtrarBtn = document.getElementById("filtrar");

    // Inicializar Flatpickr
    flatpickr("#fecha-desde", {
        dateFormat: "Y-m-d", // Formato compatible con el backend
        locale: "es",
    });

    flatpickr("#fecha-hasta", {
        dateFormat: "Y-m-d", // Formato compatible con el backend
        locale: "es",
    });

    // Función para cargar los datos
    function cargarDatos(desde = "", hasta = "") {
        let url = "/reportes-cnu/buscar";
        if (desde && hasta) {
            url += `?fecha_desde=${desde}&fecha_hasta=${hasta}`;
        }

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                tablaReportes.innerHTML = "";

                if (data.length > 0) {
                    data.forEach((reporte) => {
                        const fila = `
                            <tr>
                                <td>${reporte.carnet}</td>
                                <td>${reporte.nombres}</td>
                                <td>${reporte.apellidos}</td>
                                <td>${reporte.cedula}</td>
                                <td>${reporte.turno}</td>
                                <td>${reporte.sexo}</td>
                                <td>${reporte.area_conocimiento}</td>
                                <td>${reporte.carrera}</td>
                                <td>${reporte.sede}</td>
                                <td>${reporte.tipo_miembro}</td>
                                <td>${reporte.telefono}</td>
                                <td>${reporte.ingreso}</td>
                                <td>${reporte.numero_locker}</td>
                                <td>${reporte.sala_atencion}</td>
                                <td>${reporte.tipo_servicio}</td>
                                <td>${reporte.signatura_topografica}</td>
                                <td>${reporte.codigo_computadora}</td>
                                <td>${reporte.cantidad}</td>
                                <td>${reporte.atendido_por}</td>
                            </tr>
                        `;
                        tablaReportes.innerHTML += fila;
                    });
                } else {
                    tablaReportes.innerHTML = `
                        <tr>
                            <td colspan="17" class="text-center">No se encontraron resultados</td>
                        </tr>
                    `;
                }
            })
            .catch((error) => console.error("Error al buscar reportes:", error));
    }

    // Cargar datos al cargar la página
    cargarDatos();

    // Filtrar datos al hacer clic en el botón
    filtrarBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
        cargarDatos(desde, hasta);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const exportarPDFBtn = document.getElementById("exportar-pdf");
    const exportarExcelBtn = document.getElementById("exportar-excel");

    // Exportar PDF
    exportarPDFBtn.addEventListener("click", function () {
        const fechaDesde = document.getElementById("fecha-desde").value;
        const fechaHasta = document.getElementById("fecha-hasta").value;

        let url = `/reportes-cnu/exportar-pdf`;
        if (fechaDesde && fechaHasta) {
            url += `?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}`;
        }

        window.open(url, "_blank"); // Abrir en una nueva pestaña
    });

    // Exportar Excel
    exportarExcelBtn.addEventListener("click", function () {
        const fechaDesde = document.getElementById("fecha-desde").value;
        const fechaHasta = document.getElementById("fecha-hasta").value;

        let url = `/reportes-cnu/exportar-excel`;
        if (fechaDesde && fechaHasta) {
            url += `?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}`;
        }

        window.open(url, "_blank"); // Abrir en una nueva pestaña
    });
});
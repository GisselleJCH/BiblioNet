document.addEventListener("DOMContentLoaded", function () {
    const graficos = {};
    const tablaReportes = document.getElementById("tabla-reportes");
    const fechaDesde = document.getElementById("fecha-desde");
    const fechaHasta = document.getElementById("fecha-hasta");
    const filtrarBtn = document.getElementById("filtrar");
    const exportarTablaPDFBtn = document.getElementById("exportar-tabla-pdf");
    const exportarTablaExcelBtn = document.getElementById("exportar-tabla-excel");
    const exportarGraficosPDFBtn = document.getElementById("exportar-graficos-pdf");
    const exportarGraficosExcelBtn = document.getElementById("exportar-graficos-excel");

    // Inicializar Flatpickr para los campos de fecha
    flatpickr("#fecha-desde", {
        dateFormat: "Y-m-d", // Formato compatible con el backend
        locale: "es",
    });

    flatpickr("#fecha-hasta", {
        dateFormat: "Y-m-d", // Formato compatible con el backend
        locale: "es",
    });

    // Función para cargar los datos de la tabla
    function cargarDatos(desde = "", hasta = "") {
        let url = "/reportes-biblioteca/buscar";
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
                            <td colspan="18" class="text-center">No se encontraron resultados</td>
                        </tr>
                    `;
                }
            })
            .catch((error) => console.error("Error al buscar reportes:", error));
    }

    // Función para cargar los gráficos
    function cargarGraficos(desde = "", hasta = "") {
        let url = "/reportes-biblioteca/graficos";
        if (desde && hasta) {
            url += `?fecha_desde=${desde}&fecha_hasta=${hasta}`;
        }

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                // Actualizar contadores
                document.getElementById("total-estudiantes").textContent = data.totales.estudiantes;
                document.getElementById("total-docentes").textContent = data.totales.docentes;
                document.getElementById("total-servicios").textContent = data.totales.servicios;

                // Actualizar gráficos con Chart.js
                actualizarGrafico("grafico-area-conocimiento", "bar", data.area_conocimiento.labels, data.area_conocimiento.data, "Área de Conocimiento");
                actualizarGrafico("grafico-sexo", "pie", data.sexo.labels, data.sexo.data, "Sexo");
                actualizarGrafico("grafico-tipo-servicio", "bar", data.tipo_servicio.labels, data.tipo_servicio.data, "Tipo de Servicio");
                actualizarGrafico("grafico-sala-atencion", "bar", data.sala_atencion.labels, data.sala_atencion.data, "Sala de Atención");
                actualizarGrafico("grafico-carrera", "bar", data.carrera.labels, data.carrera.data, "Carreras");
                actualizarGrafico("grafico-turno", "pie", data.turno.labels, data.turno.data, "Turno");
                actualizarGrafico("grafico-sede", "pie", data.sede.labels, data.sede.data, "Sede");
            })
            .catch((error) => console.error("Error al cargar gráficos:", error));
    }

    // Función para actualizar un gráfico con Chart.js
    function actualizarGrafico(canvasId, tipo, etiquetas, datos, titulo) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) {
            console.error(`El elemento <canvas> con ID "${canvasId}" no existe.`);
            return;
        }
    
        const ctx = canvas.getContext("2d");
    
        // Si ya existe un gráfico para ese canvas, destruirlo
        if (graficos[canvasId]) {
            graficos[canvasId].destroy();
        }
    
        // Paleta de colores personalizada
        const colores = [
            "#ff5254", "#5cacc4", "#fcb653", "#8cd19d", 
            "#cee879", "#B3B3B3", "#001C7D", "#C00812"
        ];
    
        // Crear y almacenar el nuevo gráfico
        graficos[canvasId] = new Chart(ctx, {
            type: tipo,
            data: {
                labels: etiquetas,
                datasets: [{
                    label: titulo,
                    data: datos,
                    backgroundColor: tipo === "pie" || tipo === "bar" ? colores : "rgba(75, 192, 192, 0.5)",
                    borderColor: tipo === "pie" || tipo === "bar" ? colores : "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: tipo === "pie", // Mostrar leyenda solo en gráficos de pastel
                    },
                    title: {
                        display: true, // Mostrar el título
                        text: titulo, // Título del gráfico
                        font: {
                            size: 18,
                            weight: "bold",
                        },
                        color: "#001C7D", // Color del título
                    },
                    datalabels: {
                        color: "#000",
                        font: {
                            weight: "bold",
                        },
                        formatter: (value, context) => {
                            const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                            const porcentaje = ((value / total) * 100).toFixed(1);
                            return `${value} (${porcentaje}%)`;
                        },
                    },
                },
            },
            plugins: [ChartDataLabels], // Habilitar el plugin
        });
    }

    // Cargar datos y gráficos al cargar la página
    cargarDatos();
    cargarGraficos();

    // Filtrar datos y gráficos al hacer clic en el botón
    filtrarBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
    
        cargarGraficos(desde, hasta);
        cargarDatos(desde, hasta);
    });

    // Exportar tabla a PDF
    exportarTablaPDFBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;

        let url = `/reportes-biblioteca/exportar-tabla-pdf`;
        if (desde && hasta) {
            url += `?fecha_desde=${desde}&fecha_hasta=${hasta}`;
        }

        window.open(url, "_blank"); // Abrir en una nueva pestaña
    });

    // Exportar tabla a Excel
    exportarTablaExcelBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;

        let url = `/reportes-biblioteca/exportar-tabla-excel`;
        if (desde && hasta) {
            url += `?fecha_desde=${desde}&fecha_hasta=${hasta}`;
        }

        window.open(url, "_blank"); // Abrir en una nueva pestaña
    });

    // Exportar gráficos a PDF
    exportarGraficosPDFBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;

        const graficos = ["grafico-area-conocimiento", "grafico-sexo", "grafico-tipo-servicio", "grafico-sala-atencion", "grafico-carrera", "grafico-turno", "grafico-sede"];
        const imagenes = {};

        graficos.forEach((id) => {
            const canvas = document.getElementById(id);
            if (canvas) {
                imagenes[id] = canvas.toDataURL("image/png"); // Convertir el gráfico a base64
            }
        });

        // Enviar las imágenes y las fechas al backend
        fetch("/guardar-imagenes-graficos", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                imagenes: imagenes,
                fecha_desde: desde,
                fecha_hasta: hasta,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al guardar las imágenes");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    // Abrir el PDF generado en una nueva pestaña
                    window.open("/reportes-biblioteca/exportar-graficos-pdf", "_blank");
                } else {
                    console.error("No se pudieron guardar las imágenes");
                }
            })
            .catch((error) => console.error("Error:", error));
    });

    // Exportar gráficos a Excel
    exportarGraficosExcelBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
    
        const graficos = ["grafico-area-conocimiento", "grafico-sexo", "grafico-tipo-servicio"];
        const imagenes = {};
    
        graficos.forEach((id) => {
            const canvas = document.getElementById(id);
            if (canvas) {
                imagenes[id] = canvas.toDataURL("image/png"); // Convertir el gráfico a base64
            }
        });
    
        // Verificar los datos antes de enviarlos
        console.log("Datos enviados al backend:", {
            imagenes: imagenes,
            fecha_desde: desde,
            fecha_hasta: hasta,
        });
    
        // Enviar las imágenes al backend
        fetch("/guardar-imagenes-graficos-excel", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({
                imagenes: imagenes,
                fecha_desde: desde,
                fecha_hasta: hasta,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    return response.text().then((text) => {
                        throw new Error(`Error al guardar las imágenes para Excel: ${text}`);
                    });
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    // Abrir el archivo Excel generado en una nueva pestaña
                    window.open("/reportes-biblioteca/exportar-graficos-excel", "_blank");
                } else {
                    console.error("No se pudieron guardar las imágenes para Excel");
                }
            })
            .catch((error) => console.error("Error:", error));
    });
});
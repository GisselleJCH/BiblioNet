document.addEventListener("DOMContentLoaded", function () {
    const graficos = {};
    const tablaReportes = document.getElementById("tabla-reportes");
    const fechaDesde = document.getElementById("fecha-desde");
    const fechaHasta = document.getElementById("fecha-hasta");
    const tipoSelect = document.getElementById("tipo");
    const categoriaSelect = document.getElementById("categoria");
    const filtrarBtn = document.getElementById("filtrar");
    const exportarTablaPDFBtn = document.getElementById("exportar-tabla-pdf");
    const exportarTablaExcelBtn = document.getElementById("exportar-tabla-excel");
    const exportarGraficosPDFBtn = document.getElementById("exportar-graficos-pdf");
    const exportarGraficosExcelBtn = document.getElementById("exportar-graficos-excel");

    // Inicializar Flatpickr para los campos de fecha
    flatpickr("#fecha-desde", {
        dateFormat: "Y-m-d",
        locale: "es",
    });

    flatpickr("#fecha-hasta", {
        dateFormat: "Y-m-d",
        locale: "es",
    });

    // Opciones de categorías por tipo
    const opcionesPorTipo = {
        sexo: ["Femenino", "Masculino"],
        turno: ["Matutino", "Vespertino", "Nocturno", "Sabatino", "Dominical"],
        carrera: ["Diseño de Producto", "Diseño Integral de Comunicación", "Producción de Espectáculos", "Inglés", "Enseñanza Artística Musical", "Enseñanza Artística Musical con Mención en Violín", "Enfermería", "Técnico Superior en Enfermería", "Gastronomía con Arte Culinario",
            "Administración Turística y Hotelera", "Ingeniería en Sistemas de Información", "Ingeniería en Computación", "Ingeniería en Biotecnología", "Mercadotecnia", "Contaduría Pública y Finanzas", "Administración de Empresas", "Economía y Negocios", "Finanzas y Gestión Bancaria", "Derecho"
        ],
        area_conocimiento: ["Dirección Educación, Arte y Humanidades", "Dirección Ciencias de la Salud", "Dirección Ciencias Básicas y Tecnología", "Dirección Ciencias Sociales, Económicas Administrativas y Jurídicas"],
        sede: ["UNP Central", "UNP Extensión-Teustepe", "UNP CUR-Boaco", "UNP CUR-Estelí", "UNP CUR-Rivas"],
        tipo_servicio: ["Lectura de Material Bibliográfico en Físico", "Préstamo de Material Bibliográfico a domicilio", "Escaneo Impresión", "Préstamo de Computadora", "Entrega de solvencia", "Usuario con suscripción", "Capacitación a Usuarios", "Atención de Usuario"],
        sala_atencion: ["Sala de Lectura", "Sala de Computación", "Sala de hemeroteca", "Sala wifi", "Sala de atención al usuario", "Auditorio"],
    };

    // Cargar todos los datos al inicio
    function cargarTodosLosDatos() {
        fetch("/reportes-biblioteca/buscar")
            .then((response) => response.json())
            .then((data) => {
                cargarDatosFiltrados(data);
                cargarGraficos();
            })
            .catch((error) => console.error("Error al cargar todos los datos:", error));
    }

    // Actualizar las opciones de categoría según el tipo seleccionado
    tipoSelect.addEventListener("change", function () {
        const tipo = tipoSelect.value;

        // Limpiar las opciones de categoría
        categoriaSelect.innerHTML = "";

        if (tipo === "todo") {
            // Si el tipo es "Todo", la categoría también será "Todo"
            categoriaSelect.disabled = true;
            categoriaSelect.innerHTML = `<option value="todo">Todo</option>`;
        } else if (["signatura_topografica", "codigo_computadora", "name"].includes(tipo)) {
            // Obtener opciones dinámicas desde el backend
            fetch(`/reportes-biblioteca/opciones?tipo=${tipo}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error al cargar las opciones");
                }
                return response.json();
            })
            .then((opciones) => {
                categoriaSelect.disabled = false;
                categoriaSelect.innerHTML = `<option value="todo">Todo</option>`;
                opciones.forEach((opcion) => {
                    const optionElement = document.createElement("option");
                    optionElement.value = opcion;
                    optionElement.textContent = opcion;
                    categoriaSelect.appendChild(optionElement);
                });
            })
            .catch((error) => {
                console.error("Error al cargar las opciones:", error);
                categoriaSelect.disabled = true;
                categoriaSelect.innerHTML = `<option value="">Error al cargar opciones</option>`;
            });
        } else {
            // Opciones estáticas
            categoriaSelect.disabled = false;
            const opciones = opcionesPorTipo[tipo] || [];
            opciones.forEach((opcion) => {
                const optionElement = document.createElement("option");
                optionElement.value = opcion;
                optionElement.textContent = opcion;
                categoriaSelect.appendChild(optionElement);
            });
        }
    });

    // Filtrar datos al hacer clic en el botón
    filtrarBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
        const tipo = tipoSelect.value;
        const categoria = categoriaSelect.value;
    
        // Construir la URL con los parámetros de filtro para la tabla
        let url = `/reportes-biblioteca/buscar?fecha_desde=${desde}&fecha_hasta=${hasta}`;
    
        if (tipo && tipo !== "todo") {
            url += `&tipo=${tipo}`;
            if (categoria && categoria !== "todo") {
                url += `&categoria=${categoria}`;
            }
        }
    
        console.log("URL generada para el filtro:", url); // Debug para verificar la URL
    
        // Realizar la solicitud al backend para la tabla
        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                cargarDatosFiltrados(data);
            })
            .catch((error) => console.error("Error al filtrar datos:", error));
    
        // Cargar gráficos con los mismos filtros
        cargarGraficos(desde, hasta, tipo, categoria);
    });

    // Función para cargar los datos filtrados en la tabla
    function cargarDatosFiltrados(data) {
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
    }

    // Función para cargar los gráficos
    function cargarGraficos(desde = "", hasta = "", tipo = "", categoria = "") {
        let url = "/reportes-biblioteca/graficos";
    
        // Agregar filtros de fecha, tipo y categoría a la URL
        const params = new URLSearchParams();
        if (desde && hasta) {
            params.append("fecha_desde", desde);
            params.append("fecha_hasta", hasta);
        }
        if (tipo && tipo !== "todo") {
            params.append("tipo", tipo);
            if (categoria && categoria !== "todo") {
                params.append("categoria", categoria);
            }
        }
    
        if (params.toString()) {
            url += `?${params.toString()}`;
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
                        display: tipo === "pie",
                    },
                    title: {
                        display: true,
                        text: titulo,
                        font: {
                            size: 18,
                            weight: "bold",
                        },
                        color: "#001C7D",
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
            plugins: [ChartDataLabels],
        });
    }

    // Exportar tabla a PDF
    exportarTablaPDFBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
        const tipo = tipoSelect.value;
        const categoria = categoriaSelect.value;
    
        let url = `/reportes-biblioteca/exportar-tabla-pdf?fecha_desde=${desde}&fecha_hasta=${hasta}`;
        if (tipo && tipo !== "todo") {
            url += `&tipo=${tipo}`;
            if (categoria && categoria !== "todo") {
                url += `&categoria=${categoria}`;
            }
        }
    
        window.open(url, "_blank");
    });

    // Exportar tabla a Excel
    exportarTablaExcelBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
        const tipo = tipoSelect.value;
        const categoria = categoriaSelect.value;
    
        let url = `/reportes-biblioteca/exportar-tabla-excel?fecha_desde=${desde}&fecha_hasta=${hasta}`;
        if (tipo && tipo !== "todo") {
            url += `&tipo=${tipo}`;
            if (categoria && categoria !== "todo") {
                url += `&categoria=${categoria}`;
            }
        }
    
        window.open(url, "_blank");
    });

    // Exportar gráficos a Excel
    exportarGraficosExcelBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
        const tipo = tipoSelect.value;
        const categoria = categoriaSelect.value;
    
        const graficos = ["grafico-area-conocimiento", "grafico-sexo", "grafico-tipo-servicio"];
        const imagenes = {};
    
        graficos.forEach((id) => {
            const canvas = document.getElementById(id);
            if (canvas) {
                imagenes[id] = canvas.toDataURL("image/png");
            }
        });
    
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
                tipo: tipo !== "todo" ? tipo : null,
                categoria: categoria !== "todo" ? categoria : null,
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
                    window.open(`/reportes-biblioteca/exportar-graficos-excel?fecha_desde=${desde}&fecha_hasta=${hasta}&tipo=${tipo}&categoria=${categoria}`, "_blank");
                } else {
                    console.error("No se pudieron guardar las imágenes para Excel");
                }
            })
            .catch((error) => console.error("Error:", error));
    });

    // Exportar gráficos a PDF
    exportarGraficosPDFBtn.addEventListener("click", function () {
        const desde = fechaDesde.value;
        const hasta = fechaHasta.value;
        const tipo = tipoSelect.value;
        const categoria = categoriaSelect.value;
    
        const graficos = ["grafico-area-conocimiento", "grafico-sexo", "grafico-tipo-servicio", "grafico-sala-atencion", "grafico-carrera", "grafico-turno", "grafico-sede"];
        const imagenes = {};
    
        graficos.forEach((id) => {
            const canvas = document.getElementById(id);
            if (canvas) {
                imagenes[id] = canvas.toDataURL("image/png");
            }
        });
    
        // Enviar las imágenes y los filtros al backend
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
                tipo: tipo !== "todo" ? tipo : null,
                categoria: categoria !== "todo" ? categoria : null,
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
                    window.open(`/reportes-biblioteca/exportar-graficos-pdf?fecha_desde=${desde}&fecha_hasta=${hasta}&tipo=${tipo}&categoria=${categoria}`, "_blank");
                } else {
                    console.error("No se pudieron guardar las imágenes");
                }
            })
            .catch((error) => console.error("Error:", error));
    });

    // Cargar todos los datos al inicio
    cargarTodosLosDatos();
});
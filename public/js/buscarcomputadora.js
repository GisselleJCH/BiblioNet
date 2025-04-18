document.addEventListener("DOMContentLoaded", function () {
    const buscarInput = document.getElementById("buscar");
    const tablaComputadoras = document.getElementById("tabla-computadoras");

    buscarInput.addEventListener("input", function () {
        const termino = buscarInput.value;

        // Realizar la solicitud AJAX
        fetch(`/computadoras/buscar?buscar=${termino}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then((data) => {
                // Limpiar la tabla
                tablaComputadoras.innerHTML = "";

                // Verificar si hay resultados
                if (data.length > 0) {
                    data.forEach((computadora) => {
                        const fila = `
                            <tr>
                                <td>${computadora.marca}</td>
                                <td>${computadora.modelo}</td>
                                <td>${computadora.categoria}</td>
                                <td>${computadora.codigo_computadora}</td>
                                <td>${computadora.cantidad_disponible}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/computadoras/${computadora.id}/edit" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="/computadoras/${computadora.id}" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta computadora?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tablaComputadoras.innerHTML += fila;
                    });
                } else {
                    tablaComputadoras.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron resultados</td>
                        </tr>
                    `;
                }
            })
            .catch((error) => {
                console.error("Error al buscar computadoras:", error);
            });
    });
});
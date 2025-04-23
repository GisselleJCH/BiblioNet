document.addEventListener("DOMContentLoaded", function () {
    // Filtrar registros en la tabla
    document.getElementById('buscar').addEventListener('keyup', function () {
        var value = this.value.toLowerCase();
        var rows = document.querySelectorAll('#tabla-libros tr');
        rows.forEach(function (row) {
            var titulo = row.cells[0].textContent.toLowerCase();
            var signatura = row.cells[3].textContent.toLowerCase();
            if (titulo.includes(value) || signatura.includes(value)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
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
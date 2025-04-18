document.getElementById('buscar').addEventListener('keyup', function() {
    var value = this.value.toLowerCase();
    var rows = document.querySelectorAll('#tabla-libros tr');
    rows.forEach(function(row) {
        var titulo = row.cells[0].textContent.toLowerCase();
        var signatura = row.cells[3].textContent.toLowerCase();
        if (titulo.includes(value) || signatura.includes(value)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
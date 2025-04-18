document.addEventListener("DOMContentLoaded", function () {
    const computadorasForm = document.getElementById("computadorasForm");

    computadorasForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Evitar el envío por defecto del formulario

        const formData = new FormData(computadorasForm); // Crear un objeto FormData con los datos del formulario
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Obtener el token CSRF desde la metaetiqueta
        const actionUrl = computadorasForm.getAttribute('data-action'); // Obtener la URL desde el atributo data-action

        fetch(actionUrl, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": csrfToken // Incluir el token CSRF en los encabezados
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud");
                }
                return response.json(); // Convertir la respuesta a JSON
            })
            .then(data => {
                if (data.success) {
                    alert("Computadora registrada correctamente.");
                    computadorasForm.reset(); // Limpiar el formulario
                } else {
                    alert("Error: " + (data.message || "Ocurrió un error al registrar la computadora."));
                }
            })
            .catch(error => {
                console.error("Error en el registro:", error);
                alert("Ocurrió un error al registrar la computadora.");
            });
    });
});
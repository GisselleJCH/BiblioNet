document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-carnet");
    const suggestionsContainer = document.getElementById("search-suggestions");
    const registerMiembrosModal = new bootstrap.Modal(document.getElementById("registerMiembrosModal"));
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : "";

    if (!csrfToken) {
        console.error("CSRF token not found!");
    }

    // Autocompletar búsqueda por carnet
    searchInput.addEventListener("input", function () {
        const query = searchInput.value.trim();
        if (query.length >= 3) {
            fetch(`/buscar-miembro?carnet=${query}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(miembro => {
                            const item = document.createElement("div");
                            item.classList.add("list-group-item", "list-group-item-action");
                            item.textContent = `${miembro.carnet} - ${miembro.nombres} ${miembro.apellidos}`;
                            item.addEventListener("click", () => fillUserData(miembro));
                            suggestionsContainer.appendChild(item);
                        });
                    } else {
                        showNoResults();
                    }
                })
                .catch(error => console.error("Error en la búsqueda:", error));
        } else {
            suggestionsContainer.innerHTML = "";
        }
    });

    // Llenar formulario con los datos del usuario encontrado
    function fillUserData(miembro) {
        document.getElementById("miembro_id").value = miembro.id;
        document.getElementById("carnet").value = miembro.carnet;
        document.getElementById("nombres").value = miembro.nombres;
        document.getElementById("apellidos").value = miembro.apellidos;
        document.getElementById("cedula").value = miembro.cedula;
        document.getElementById("carrera").value = miembro.carrera;
        document.getElementById("turno").value = miembro.turno;
        document.getElementById("sexo").value = miembro.sexo;
        document.getElementById("area_conocimiento").value = miembro.area_conocimiento;
        document.getElementById("sede").value = miembro.sede;
        document.getElementById("tipo_miembro").value = miembro.tipo_miembro; 
        document.getElementById("telefono").value = miembro.telefono;
        suggestionsContainer.innerHTML = "";
    }

    function showNoResults() {
        const item = document.createElement("div");
        item.classList.add("list-group-item", "list-group-item-action", "text-danger");
        item.innerHTML = `No existe registro<br><a href="#" id="register-new-miembro">¿Desea hacer el nuevo registro?</a>`;
        item.addEventListener("click", () => {
            registerMiembrosModal.show();
            searchInput.value = "";
        });
        suggestionsContainer.appendChild(item);
    }

    // Manejar registro de nuevo usuario
    document.getElementById("saveMiembrosButton").addEventListener("click", function () {
        const formData = new FormData(document.getElementById("registerMiembrosForm"));
        fetch("/registrar-miembro", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                registerMiembrosModal.hide();
                fillUserData(data.miembro);
                alert("Usuario registrado exitosamente.");
            } else {
                alert("Error al registrar usuario: " + (data.message || "Inténtalo de nuevo."));
            }
        })
        .catch(error => {
            console.error("Error en el registro:", error);
            alert("Ocurrió un error al registrar el usuario.");
        });
    });

    // Mostrar campos adicionales según el tipo de servicio
    document.getElementById("tipo_servicio").addEventListener("change", function () {
        const extraFields = document.getElementById("extra-fields");
        extraFields.innerHTML = "";
    
        if ('Préstamo de Computadora' === this.value) {
            extraFields.innerHTML = `
                <div class="col-md-6">
                    <label for="codigo_computadora" class="col-form-label fw-bold">Código de Computadora</label>
                    <input id="codigo_computadora" type="text" class="form-control" name="codigo_computadora" required>
                    <div id="computadora-suggestions" class="list-group mt-3"></div>
                </div>
                <div class="col-md-6"> 
                    <label for="cantidad" class="col-form-label fw-bold">Cantidad</label>
                    <input id="cantidad" type="number" class="form-control" name="cantidad" min="1" value="1">
                </div>
            `;
    
            const computadoraInput = document.getElementById("codigo_computadora");
            const suggestionsContainer = document.getElementById("computadora-suggestions");
    
            computadoraInput.addEventListener("input", function () {
                const query = computadoraInput.value.trim();
                if (query.length >= 2) {
                    fetch(`/buscar-computadoras?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsContainer.innerHTML = "";
                            if (data.length > 0) {
                                data.forEach(codigo => {
                                    const item = document.createElement("div");
                                    item.classList.add("list-group-item", "list-group-item-action");
                                    item.textContent = codigo;
                                    item.addEventListener("click", () => {
                                        computadoraInput.value = codigo;
                                        suggestionsContainer.innerHTML = "";
                                    });
                                    suggestionsContainer.appendChild(item);
                                });
                            } else {
                                suggestionsContainer.innerHTML = `<div class="list-group-item text-danger">No se encontraron resultados</div>`;
                            }
                        })
                        .catch(error => console.error("Error al buscar computadoras:", error));
                } else {
                    suggestionsContainer.innerHTML = "";
                }
            });
        } else if (['Lectura de Material Bibliográfico en Físico', 'Préstamo de Material Bibliográfico a domicilio'].includes(this.value)) {
            extraFields.innerHTML = `
                <div class="col-md-6">
                    <label for="signatura_topografica" class="col-form-label fw-bold">Signatura Topográfica</label>
                    <input id="signatura_topografica" type="text" class="form-control" name="signatura_topografica" required>
                    <div id="signatura-suggestions" class="list-group mt-3"></div>
                </div>
                <div class="col-md-6"> 
                    <label for="cantidad" class="col-form-label fw-bold">Cantidad</label>
                    <input id="cantidad" type="number" class="form-control" name="cantidad" min="1" value="1">
                </div>
            `;
            
            const signaturaInput = document.getElementById("signatura_topografica");
            const suggestionsContainer = document.getElementById("signatura-suggestions");

            signaturaInput.addEventListener("input", function () {
                const query = signaturaInput.value.trim();
                if (query.length >= 2) {
                    fetch(`/buscar-signaturas?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsContainer.innerHTML = "";
                            if (data.length > 0) {
                                data.forEach(signatura => {
                                    const item = document.createElement("div");
                                    item.classList.add("list-group-item", "list-group-item-action");
                                    item.textContent = signatura;
                                    item.addEventListener("click", () => {
                                        signaturaInput.value = signatura;
                                        suggestionsContainer.innerHTML = "";
                                    });
                                    suggestionsContainer.appendChild(item);
                                });
                            } else {
                                suggestionsContainer.innerHTML = `<div class="list-group-item text-danger">No se encontraron resultados</div>`;
                            }
                        })
                        .catch(error => console.error("Error al buscar signaturas:", error));
                } else {
                    suggestionsContainer.innerHTML = "";
                }
            });
        }
    });
});
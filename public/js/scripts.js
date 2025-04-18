document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.querySelector('.sidebar');
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        if (sidebar.classList.contains('collapsed')) {
            dropdownBtns.forEach(btn => {
                const subMenu = btn.nextElementSibling;
                const iconArrow = btn.querySelector('.icon-arrow');
                if (subMenu && subMenu.classList.contains('sub-menu')) {
                    subMenu.style.display = 'none';
                }
                if (iconArrow) {
                    iconArrow.classList.remove('rotate');
                }
            });
        }
    });

    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const isActive = this.classList.contains('active');
            const subMenu = this.nextElementSibling;
            const iconArrow = this.querySelector('.icon-arrow');

            // Remover la clase 'active' de todos los botones y ocultar sus submenús
            dropdownBtns.forEach(b => {
                b.classList.remove('active');
                const subMenu = b.nextElementSibling;
                const iconArrow = b.querySelector('.icon-arrow');
                if (subMenu && subMenu.classList.contains('sub-menu')) {
                    subMenu.style.display = 'none';
                }
                if (iconArrow) {
                    iconArrow.classList.remove('rotate');
                }
            });

            // Alternar la clase 'active' y la visibilidad del submenú del botón clicado
            if (!isActive) {
                this.classList.add('active');
                if (subMenu && subMenu.classList.contains('sub-menu')) {
                    subMenu.style.display = 'block';
                    if (sidebar.classList.contains('collapsed')) {
                        subMenu.style.display = 'none'; // Oculta el submenú cuando el sidebar está colapsado
                    }
                }
                if (iconArrow) {
                    iconArrow.classList.add('rotate');
                }
            } else {
                this.classList.remove('active');
                if (subMenu && subMenu.classList.contains('sub-menu')) {
                    subMenu.style.display = 'none';
                }
                if (iconArrow) {
                    iconArrow.classList.remove('rotate');
                }
            }
        });
    });
});
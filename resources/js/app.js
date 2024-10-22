document.addEventListener('DOMContentLoaded', function () {
    const themeToggleButton = document.getElementById('themeToggleButton');
    const themeMenu = document.getElementById('themeMenu');
    const icon = document.getElementById('themeIcon');
    
    const storedTheme = localStorage.getItem('theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)');
    
    // Inicialización del tema actual: 
    if (!storedTheme) {
        // Si no hay preferencia guardada, usar el sistema
        if (systemDark.matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        updateIcon('system');
    } else {
        // Si hay una preferencia guardada, aplicarla
        setTheme(storedTheme);
    }

    // Función para cambiar el tema
    function setTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (theme === 'light') {
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('theme', theme);
        updateIcon(theme);
    }

    // Actualización del ícono según el tema
    function updateIcon(theme) {
        if (theme === 'light') {
            icon.innerHTML = `<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2ZM10 15a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15ZM10 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6ZM15.657 5.404a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM6.464 14.596a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10ZM14.596 15.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06Z"></path>
                            </svg>`;
        } else if (theme === 'dark') {
            icon.innerHTML = `<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 0 1 .26.77 7 7 0 0 0 9.958 7.967.75.75 0 0 1 1.067.853A8.5 8.5 0 1 1 6.647 1.921a.75.75 0 0 1 .808.083Z" clip-rule="evenodd"></path>
                            </svg>`;
        } else {
            icon.innerHTML = `<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2 4.25A2.25 2.25 0 0 1 4.25 2h11.5A2.25 2.25 0 0 1 18 4.25v8.5A2.25 2.25 0 0 1 15.75 15h-3.105a3.501 3.501 0 0 0 1.1 1.677A.75.75 0 0 1 13.26 18H6.74a.75.75 0 0 1-.484-1.323A3.501 3.501 0 0 0 7.355 15H4.25A2.25 2.25 0 0 1 2 12.75v-8.5Zm1.5 0a.75.75 0 0 1 .75-.75h11.5a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-.75.75H4.25a.75.75 0 0 1-.75-.75v-7.5Z" clip-rule="evenodd"></path>
                            </svg>`;
        }
    }

    // Mostrar menú de opciones
    themeToggleButton.addEventListener('click', function () {
        themeMenu.classList.toggle('hidden');
    });

    // Selección de tema al hacer clic en una opción
    document.getElementById('lightThemeButton').addEventListener('click', function () {
        setTheme('light');
        themeMenu.classList.add('hidden');
    });

    document.getElementById('darkThemeButton').addEventListener('click', function () {
        setTheme('dark');
        themeMenu.classList.add('hidden');
    });

    document.getElementById('systemThemeButton').addEventListener('click', function () {
        localStorage.removeItem('theme');
        if (systemDark.matches) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        updateIcon('system');
        themeMenu.classList.add('hidden');
    });

    // Detectar cambio de sistema (modo oscuro o claro)
    systemDark.addEventListener('change', function (e) {
        if (!localStorage.getItem('theme')) {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    });
    // Refrescar las tabs
    window.addEventListener('refresh-table', function () {
        Livewire.emit('refreshTable');
    });
});

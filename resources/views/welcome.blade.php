<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Toggle</title>
    @vite('resources/css/app.css') <!-- Tailwind ya configurado -->
</head>
<body class="bg-white dark:bg-gray-950 transition-colors duration-500">
   <!-- Botón de selección de tema -->
   <div class="fixed top-4 right-4">
    <div class="relative">
        <button
            id="themeToggleButton"
            aria-label="Switch theme"
            class="p-3 rounded-full bg-gray-100 drop-shadow-lg dark:shadow-lg dark:shadow-gray-900 dark:bg-gray-950 text-blue-600 dark:text-blue-400 focus:outline-none"
        >
            <span id="themeIcon"></span>
        </button>
        <!-- Menú de opciones para seleccionar tema -->
        <div id="themeMenu" class="absolute right-0 mt-2 bg-white dark:bg-gray-950 rounded-lg shadow-lg dark:shadow-gray-900 hidden">
            <ul class="flex">
                <li>
                    <button id="lightThemeButton" class="w-full text-left px-4 py-2 rounded-l-lg hover:bg-gray-200 dark:hover:bg-gray-900 ">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2ZM10 15a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15ZM10 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6ZM15.657 5.404a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM6.464 14.596a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10ZM14.596 15.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z"></path>
                        </svg>
                    </button>
                </li>
                <li>
                    <button id="darkThemeButton" class="w-full text-left px-4 py-2 hover:bg-gray-200 dark:hover:bg-gray-900">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 0 1 .26.77 7 7 0 0 0 9.958 7.967.75.75 0 0 1 1.067.853A8.5 8.5 0 1 1 6.647 1.921a.75.75 0 0 1 .808.083Z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </li>
                <li>
                    <button id="systemThemeButton" class="w-full text-left px-4 py-2 rounded-r-lg hover:bg-gray-200 dark:hover:bg-gray-900">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 4.25A2.25 2.25 0 0 1 4.25 2h11.5A2.25 2.25 0 0 1 18 4.25v8.5A2.25 2.25 0 0 1 15.75 15h-3.105a3.501 3.501 0 0 0 1.1 1.677A.75.75 0 0 1 13.26 18H6.74a.75.75 0 0 1-.484-1.323A3.501 3.501 0 0 0 7.355 15H4.25A2.25 2.25 0 0 1 2 12.75v-8.5Zm1.5 0a.75.75 0 0 1 .75-.75h11.5a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-.75.75H4.25a.75.75 0 0 1-.75-.75v-7.5Z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-950">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-gray-800 dark:text-gray-100 transition-colors duration-500">
                Bienvenido a <span class="text-blue-600 dark:text-blue-400">Becas UCLV</span>
            </h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                Gestione su proyecto con facilidad y estilo.
            </p>
            <div class="mt-8">
                <a href="/admin/login" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-700 dark:hover:bg-blue-500 transition-colors duration-300">
                    Ir al Panel de Administración
                </a>
            </div>
        </div>
    </section>

    <!-- Sección adicional -->
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">Características Principales</h2>
            <p class="mt-4 text-gray-600 dark:text-gray-300">Descubra las características que hacen de este sistema una herramienta potente y flexible.</p>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400">Gestión Intuitiva</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Administre sus datos con facilidad.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400">Seguridad</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Sus datos siempre estarán protegidos.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-blue-600 dark:text-blue-400">Velocidad</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Optimizado para un rendimiento rápido.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Pie de página -->
    <footer class="text-center py-4 bg-gray-100 dark:bg-gray-800">
        <p class="text-gray-600 dark:text-gray-300">© 2024 Student Management System. All rights reserved.</p>
    </footer>
    @vite('resources/js/app.js')
</body>
</html>

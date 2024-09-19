<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gestión de Residencias UCLV</h1>
            <nav>
                <a href="#features" class="hover:underline">Características</a>
                <a href="#about" class="ml-4 hover:underline">Sobre el Proyecto</a>
                <a href="admin/login" class="ml-4 bg-blue-800 px-4 py-2 rounded">Acceder</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-800 text-white h-screen flex flex-col justify-center items-center text-center">
        <h2 class="text-4xl font-bold mb-4">Bienvenido al Sistema de Gestión de Residencias de UCLV</h2>
        <p class="text-lg mb-6">Facilitamos la gestión de residencias estudiantiles con eficiencia y facilidad.</p>
        <a href="admin/login" class="bg-blue-600 px-6 py-3 rounded text-white font-semibold">Accede al Sistema</a>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Características Clave</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Gestión de Habitaciones</h3>
                    <p>Asigna y gestiona habitaciones de manera eficiente.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Asignación de Estudiantes</h3>
                    <p>Administra la asignación de estudiantes a sus habitaciones.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-2">Manejo de Quejas</h3>
                    <p>Registra y gestiona las quejas de los estudiantes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-gray-200 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Sobre el Proyecto</h2>
            <p class="text-center">Este sistema fue desarrollado para mejorar la gestión de residencias en UCLV, facilitando la administración y proporcionando una experiencia más eficiente para los administradores y estudiantes.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4 text-center">
        <p>&copy; 2024 UCLV. Todos los derechos reservados.</p>
    </footer>

    @vite('resources/js/app.js')
</body>
</html>
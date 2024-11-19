<x-filament-panels::page>
    <!-- Bienvenida -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Welcome, {{ auth()->user()->student->name }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">
            Below is your personal dashboard with key information.
        </p>
    </div>

    <!-- Información Personal -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Personal Information</h3>
            <p class="text-gray-600 dark:text-gray-400 mt-2"><strong>Name:</strong> {{ auth()->user()->student->name }} {{ auth()->user()->student->last_name }}</p>
            <p class="text-gray-600 dark:text-gray-400 mt-2"><strong>DNI:</strong> {{ auth()->user()->student->dni }}</p>
            <p class="text-gray-600 dark:text-gray-400"><strong>Career:</strong> {{ auth()->user()->student->group->careerYear->career->name }}</p>
            <p class="text-gray-600 dark:text-gray-400"><strong>Year:</strong> {{ auth()->user()->student->group->careerYear->name }}</p>
        </div>

        <!-- Información de la Residencia -->
        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Residence Information</h3>
            <p class="text-gray-600 dark:text-gray-400 mt-2"><strong>Building:</strong> {{ auth()->user()->student->room->wing->building->name }}</p>
            <p class="text-gray-600 dark:text-gray-400"><strong>Wing:</strong> {{ auth()->user()->student->room->wing->name }}</p>
            <p class="text-gray-600 dark:text-gray-400"><strong>Room Number:</strong> {{ auth()->user()->student->room->number }}</p>
        </div>
    </div>

    <!-- Historial de Cuartelerías -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md mt-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Duty History</h3>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Check your scheduled duties and their statuses below.</p>
        <div class="mt-4 space-y-2">
            <p class="text-gray-600 dark:text-gray-400">
                Duty Date: <strong class="text-gray-800 dark:text-white">---</strong> - Status: <strong class="text-gray-800 dark:text-white">---</strong>
            </p>
            <p class="text-gray-600 dark:text-gray-400">
                Duty Date: <strong class="text-gray-800 dark:text-white">---</strong> - Status: <strong class="text-gray-800 dark:text-white">---</strong>
            </p>
        </div>
    </div>
</x-filament-panels::page>

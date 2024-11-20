<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
    <div class="bg-blue-500 p-4 text-white rounded-lg shadow-md">
        <h3 class="text-xl font-semibold">Pendientes</h3>
        <p class="text-2xl">{{ $pending }}</p>
    </div>
    <div class="bg-yellow-500 p-4 text-white rounded-lg shadow-md">
        <h3 class="text-xl font-semibold">Revisadas</h3>
        <p class="text-2xl">{{ $reviewed }}</p>
    </div>
    <div class="bg-green-500 p-4 text-white rounded-lg shadow-md">
        <h3 class="text-xl font-semibold">Resueltas</h3>
        <p class="text-2xl">{{ $resolved }}</p>
    </div>
</div>

<div x-data="{ open: false }" @open-modal.window="open = true" @close-modal.window="open = false">
    <x-filament::modal width="lg" x-show="open" @click.away="open = false">
        <form wire:submit.prevent="addWing">
            <x-filament::input type="text" wire:model="wing_name" placeholder="Wing Name" />
            <x-filament::button type="submit">Add Wing</x-filament::button>
        </form>

        <!-- Lista de alas añadidas -->
        <ul>
            @foreach ($wings as $wing)
                <li>{{ $wing }}</li>
            @endforeach
        </ul>
    </x-filament::modal>
</div>

<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Reseller</h2>
            <p class="mt-1 text-sm text-slate-600">Details, customers, users and billing.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @livewire('reseller.show-reseller', ['reseller' => $reseller->id])
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Price List</h2>
            <p class="mt-1 text-sm text-slate-600">Edit prices, import/export, and manage effective lists.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                @livewire('pricelist.show-pricelist', ['priceList' => $priceList], key($priceList->id))
            </div>
        </div>
    </div>
</x-app-layout>


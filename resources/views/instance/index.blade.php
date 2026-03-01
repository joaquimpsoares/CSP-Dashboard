<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Instances</h2>
            <p class="mt-1 text-sm text-slate-600">Manage CSP instances (Microsoft/Kaspersky/etc), tokens, and expiration.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                @livewire('instance.instance-table')
            </div>
        </div>
    </div>
</x-app-layout>

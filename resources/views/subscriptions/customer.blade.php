<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Subscriptions</h2>
                <p class="mt-1 text-sm text-slate-600">Manage and review subscriptions.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @livewire('subscription.subscription-costumer')
        </div>
    </div>
</x-app-layout>

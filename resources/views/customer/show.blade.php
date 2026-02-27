<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Customer</h2>
            <p class="mt-1 text-sm text-slate-600">Customer details, subscriptions and usage.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                @livewire('customer.show-customer', ['customer' => $customer, 'countries' => $countries, 'statuses' => $statuses], key($customer->id))
            </div>
        </div>
    </div>
</x-app-layout>

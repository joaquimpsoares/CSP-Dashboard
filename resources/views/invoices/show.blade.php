<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Invoice #{{ $invoice->id }}</h2>
                <p class="mt-1 text-sm text-slate-600">Order: {{ $invoice->order_id ?? '—' }} · Currency: {{ $invoice->currency ?? '—' }}</p>
            </div>
            <div>
                <a href="{{ route('invoices_new.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 bg-white">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    <th class="px-4 py-3">SKU</th>
                                    <th class="px-4 py-3">Qty</th>
                                    <th class="px-4 py-3">Unit sell</th>
                                    <th class="px-4 py-3">Total sell</th>
                                    <th class="px-4 py-3">Rule</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($invoice->lines as $line)
                                    <tr class="text-sm text-slate-800">
                                        <td class="px-4 py-3 font-mono text-xs">{{ $line->product_sku ?? '—' }}</td>
                                        <td class="px-4 py-3">{{ $line->quantity }}</td>
                                        <td class="px-4 py-3">{{ number_format((float)($line->getUnitSellPrice() ?? 0), 2) }} {{ $line->currency ?? $invoice->currency }}</td>
                                        <td class="px-4 py-3">{{ number_format((float)($line->getTotalSellPrice() ?? 0), 2) }} {{ $line->currency ?? $invoice->currency }}</td>
                                        <td class="px-4 py-3">{{ $line->pricing_rule_id ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-10 text-sm text-slate-500" colspan="5">No lines.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

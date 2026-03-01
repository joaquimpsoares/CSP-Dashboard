<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Invoices (snapshotted)</h2>
            <p class="mt-1 text-sm text-slate-600">New invoices built from invoice_lines. Legacy Microsoft/BulletHQ invoices remain available in their existing screens.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="p-6">
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="min-w-full divide-y divide-slate-200 bg-white">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Order</th>
                                    <th class="px-4 py-3">Customer</th>
                                    <th class="px-4 py-3">Currency</th>
                                    <th class="px-4 py-3">Created</th>
                                    <th class="px-4 py-3 text-right"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($invoices as $inv)
                                    <tr class="text-sm text-slate-800">
                                        <td class="px-4 py-3 font-semibold">#{{ $inv->id }}</td>
                                        <td class="px-4 py-3">{{ $inv->order_id ?? '—' }}</td>
                                        <td class="px-4 py-3">{{ $inv->customer_id ?? '—' }}</td>
                                        <td class="px-4 py-3">{{ $inv->currency ?? '—' }}</td>
                                        <td class="px-4 py-3">{{ optional($inv->created_at)->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('invoices_new.show', $inv->id) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Open</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-10 text-sm text-slate-500" colspan="6">No invoices yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

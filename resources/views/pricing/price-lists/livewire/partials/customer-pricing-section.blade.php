<div>
    <x-bladewind.card title="Pricing">
        @if($assignments->isEmpty())
            <p class="text-sm text-gray-500">
                No price list override assigned for this customer.
                The resolver will fall back to the <strong>reseller default</strong> (if set) or the
                <strong>provider default</strong>.
                To assign an override, open a price list and use its
                <a href="{{ route('pricing.price_lists.index') }}" class="text-indigo-600 underline hover:text-indigo-800">Assignments</a>
                tab.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Price list</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Via reseller</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Market</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Currency</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">List type</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($assignments as $a)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-indigo-700">
                                    @if($a->priceList)
                                        <a href="{{ route('pricing.price_lists.show', $a->price_list_id) }}"
                                           class="hover:underline">
                                            {{ $a->priceList->name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $a->reseller?->company_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $a->market ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $a->currency ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $listTypes[$a->list_type] ?? ($a->list_type ? $a->list_type : '—') }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($a->priceList)
                                        @php $status = $a->priceList->status; @endphp
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold
                                            {{ $status === 'active' ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : '' }}
                                            {{ $status === 'draft' ? 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200' : '' }}
                                            {{ $status === 'expired' ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : '' }}
                                            {{ $status === 'archived' ? 'bg-gray-100 text-gray-600 ring-1 ring-gray-200' : '' }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-3 text-xs text-gray-500">
                This customer's override takes the highest priority in the resolver chain
                (customer → reseller → provider).
                Manage from the
                <a href="{{ route('pricing.price_lists.index') }}" class="text-indigo-600 underline hover:text-indigo-800">Price Lists</a>
                page.
            </p>
        @endif
    </x-bladewind.card>
</div>

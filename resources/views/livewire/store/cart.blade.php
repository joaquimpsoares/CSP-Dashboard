<div class="p-6">
    <div class="mb-4 flex items-start justify-between gap-4">
        <div>
            <h3 class="text-base font-semibold text-slate-900">Cart</h3>
            <p class="mt-1 text-sm text-slate-600">This is the full cart view. Use the drawer for quick edits.</p>
        </div>
        <a href="{{ route('store.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">Continue shopping</a>
    </div>

    @if (isset($cart) && count($cart))
        <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Billing</th>
                        <th class="px-4 py-3 text-right">Unit</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($cart as $item)
                        <tr class="text-sm text-slate-800">
                            <td class="px-4 py-3 font-semibold text-slate-900">{{ $item->product_name }}</td>
                            <td class="px-4 py-3">
                                <div class="inline-flex items-center rounded-xl border border-slate-200 bg-white p-1">
                                    <button type="button" wire:click="decreaseQuantity('{{ $item->id }}','{{ $item->qty }}')"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 10a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                                    </button>
                                    <input type="number" wire:change="changeQty($event.target.value, '{{ $item->id }}')" value="{{ $item->qty }}"
                                        class="h-9 w-16 border-0 bg-transparent text-center text-sm font-semibold text-slate-900 focus:outline-none focus:ring-0" />
                                    <button type="button" wire:click="increaseQuantity('{{ $item->id }}','{{ $item->qty }}')"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 4a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V5a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if(!empty($item->term_duration))
                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">{{ $item->term_duration }}</span>
                                @endif
                                @if(!empty($item->billing_cycle))
                                    <span class="ml-2 inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">{{ $item->billing_cycle }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">{{ number_format((float)$item->price, 2) }}</td>
                            <td class="px-4 py-3 text-right">{{ number_format((float)$item->total, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <button type="button" wire:click="removeItem('{{ $item->id }}')"
                                    class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <span class="sr-only">Remove</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <div class="text-sm text-slate-600">Subtotal:</div>
            <div class="text-lg font-semibold text-slate-900">{{ number_format((float)($totalCartWithoutTax ?? 0), 2) }}</div>
            <button type="button" wire:click="checkout"
                class="ml-3 inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                Continue to checkout
            </button>
        </div>
    @else
        <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center">
            <div class="text-base font-semibold text-slate-900">Your cart is empty</div>
            <div class="mt-1 text-sm text-slate-600">Browse the store and add products.</div>
            <a href="{{ route('store.index') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Return to store</a>
        </div>
    @endif
</div>

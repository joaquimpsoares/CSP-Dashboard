<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Cart</h2>
                <p class="mt-1 text-sm text-slate-600">Review items before checkout.</p>
            </div>
            <a href="{{ route('store.index') }}" class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                Continue shopping
            </a>
        </div>
    </x-slot>

    <script>
        function updateCartProductItemsNumber(item){
            let tr = item.closest('tr');
            updateCartLine(tr);
        }

        function updateCartProductCycle(item){
            let tr = item.closest('tr');
            updateCartLine(tr);
        }

        function updateCartLine(tr){
            let quantity = tr.getElementsByClassName('form-control')[0].value;
            let price = parseFloat(tr.getElementsByClassName('product-price')[0]?.innerHTML ?? '0');
            let cycle = tr.getElementsByClassName('billing_cycle')[0]?.value ?? 'monthly';

            var subtotal = price * quantity;
            if(cycle === 'annual'){
                subtotal *= 12;
            }

            const cell = tr.getElementsByClassName('product-line-price')[0];
            if (cell) cell.innerHTML = subtotal.toFixed(2);
        }
    </script>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="p-6">
                    @if($cart)
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $cart->token }}" name="token" />

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(trans_choice('messages.quantity', 2)) }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(__('messages.billing_cycle')) }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(__('messages.subscription_period')) }}</th>
                                            @if(Auth::user()->userLevel->name == "Reseller")
                                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(trans_choice('messages.price', 1)) }}</th>
                                            @endif
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(trans_choice('messages.customer_price', 1)) }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(__('messages.subtotal')) }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @forelse($cart->products as $product)
                                            <tr class="product">
                                                <td class="px-4 py-3 text-sm text-slate-900">
                                                    {{ $product->name }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input onchange="updateCartProductItemsNumber(this)" type="number" value="{{ $product->pivot->quantity }}" name="{{ $product->pivot->id }}" id="quantity" class="form-control block w-28 rounded-lg border border-slate-300 px-2 py-1 text-sm" step="1" required min="{{ $product->minimum_quantity }}" max="{{ $product->maximum_quantity }}"/>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <select class="form-control billing_cycle block w-40 rounded-lg border border-slate-300 px-2 py-1 text-sm" onchange="updateCartProductCycle(this)" name="billing_cycle[{{ $product->pivot->id }}]" required="required" id="{{ $product->pivot->id }}">
                                                        <option value="">{{ ucwords(__('messages.choose_one')) }}</option>
                                                        @foreach($product->supported_billing_cycles as $cycle)
                                                            <option value="{{ $cycle }}" @if($cycle == $product->pivot->billing_cycle) selected @endif>
                                                                {{ucfirst($cycle) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="text" disabled="disabled" value="{{ $product->term }} Year" class="block w-28 rounded-lg border border-slate-200 bg-slate-50 px-2 py-1 text-sm text-slate-600" />
                                                </td>
                                                @if(Auth::user()->userLevel->name == "Reseller")
                                                    <td class="px-4 py-3 text-sm text-slate-700 product-price">{{ $product->pivot->price }}</td>
                                                @endif
                                                <td class="px-4 py-3 text-sm text-slate-700">{{ $product->pivot->retail_price }}</td>
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-900 product-line-price">
                                                    {{ number_format(floatval($product->pivot->retail_price * $product->pivot->quantity), 2) }}
                                                </td>
                                                <td class="px-4 py-3">
                                                    <a class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="{{ route('cart.remove_product', $product->pivot->id) }}">
                                                        Remove
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-4 py-8 text-center text-sm text-slate-600">The cart is empty.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-6 flex items-center justify-end gap-3">
                                <button type="submit" class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                    Checkout
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6">
                            <div class="text-sm font-semibold text-slate-900">The cart is empty</div>
                            <a href="{{ route('store.index') }}" class="mt-3 inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">Continue shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div x-data="{ cartOpen: false }" @keydown.escape.stop="cartOpen = false" class="flex items-center">
    {{-- Shopify-like cart drawer v1 --}}
    @php
        $user = auth()->user();
        $cartModel = $user?->cart;
        $cartCount = $cartModel?->products?->count() ?? 0;
        $cartNeedsTenant = false;
        $tenantVerified = false;
    @endphp

    @can('marketplace.index')

        <button @click="cartOpen = !cartOpen" type="button"
            class="relative inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
            <span class="sr-only">Open cart</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>

            @if($cartCount > 0)
                <span class="ml-2 inline-flex items-center rounded-full bg-rose-600 px-2 py-0.5 text-xs font-semibold text-white">
                    {{ $cartCount }}
                </span>
            @endif
        </button>
    @endcan

    <!-- Drawer -->
    <div x-cloak x-show="cartOpen" class="fixed inset-0 z-[9999]" aria-labelledby="cart-title" role="dialog" aria-modal="true">
        <!-- overlay -->
        <div class="absolute inset-0 bg-slate-900/30" @click="cartOpen = false" aria-hidden="true"></div>

        <div class="absolute inset-y-0 right-0 flex w-full max-w-md">
            <div x-show="cartOpen"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="flex h-full w-full flex-col bg-white shadow-sm">

                @php
                    if ($cartModel && $cartModel->products) {
                        foreach ($cartModel->products as $p) {
                            $v = strtolower($p->vendor ?? '');
                            if ($v === 'microsoft' || $v === 'microsoft corporation') {
                                $cartNeedsTenant = true;
                                break;
                            }
                        }
                    }
                    $tenantVerified = ($cartModel?->verify === true) && !empty($cartModel?->tenant_id) && !empty($cartModel?->domain);
                @endphp

                <!-- Header -->
                <div class="border-b border-slate-200 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 id="cart-title" class="text-base font-semibold text-slate-900">Cart</h2>
                                @if($cartCount > 0)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">{{ $cartCount }} items</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-slate-600">Review items and continue to checkout.</p>
                        </div>

                        <button @click="cartOpen = false" type="button"
                            class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    @if($cartNeedsTenant)
                        <div class="mt-4">
                            @if($tenantVerified)
                                <div class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-800">
                                    <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                                    Tenant verified
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-sm font-semibold text-amber-800">
                                    <span class="h-2 w-2 rounded-full bg-amber-600"></span>
                                    Tenant required
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Items -->
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    @if (isset($cart) && count($cart))
                        <div class="space-y-3">
                            @foreach ($cart as $item)
                                @php
                                    $vendor = strtolower($item->vendor ?? '');
                                    $vendorLabel = $vendor ? ucfirst($vendor) : 'Vendor';
                                    $minQ = (int)($item->minimum_quantity ?? 1);
                                    $maxQ = (int)($item->maximum_quantity ?? 0);
                                    $qty = (int)($item->qty ?? 1);
                                    $canDec = $qty > $minQ;
                                    $canInc = $maxQ > 0 ? $qty < $maxQ : true;
                                @endphp

                                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <div class="truncate text-sm font-semibold text-slate-900">{{ $item->product_name }}</div>
                                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">
                                                    {{ $vendorLabel }}
                                                </span>
                                            </div>

                                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                                @if(!empty($item->term_duration))
                                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">{{ $item->term_duration }}</span>
                                                @endif
                                                @if(!empty($item->billing_cycle))
                                                    <span class="inline-flex items-center rounded-full bg-slate-50 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">{{ $item->billing_cycle }}</span>
                                                @endif
                                                @if(!empty($item->productType) && $item->productType === 'OnlineServicesNCE')
                                                    <span class="inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-semibold text-primary-700 ring-1 ring-inset ring-primary-200">NCE</span>
                                                @endif
                                            </div>

                                            <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                                <div>
                                                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Unit</div>
                                                    <div class="mt-0.5 font-semibold text-slate-900">{{ number_format((float)$item->price, 2) }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total</div>
                                                    <div class="mt-0.5 font-semibold text-slate-900">{{ number_format((float)$item->total, 2) }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" wire:click="removeItem('{{ $item->id }}')"
                                            class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                            <span class="sr-only">Remove</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="mt-4 flex items-center justify-between gap-3">
                                        <div class="inline-flex items-center rounded-xl border border-slate-200 bg-white p-1">
                                            <button type="button" @disabled(!$canDec) wire:click="decreaseQuantity('{{ $item->id }}','{{ $item->qty }}')"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 disabled:opacity-40 disabled:cursor-not-allowed">
                                                <span class="sr-only">Decrease</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 10a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                                            </button>

                                            <input type="number" min="{{ $minQ }}" @if($maxQ>0) max="{{ $maxQ }}" @endif
                                                wire:change="changeQty($event.target.value, '{{ $item->id }}')"
                                                value="{{ $item->qty }}"
                                                class="h-9 w-16 border-0 bg-transparent text-center text-sm font-semibold text-slate-900 focus:outline-none focus:ring-0" />

                                            <button type="button" @disabled(!$canInc) wire:click="increaseQuantity('{{ $item->id }}','{{ $item->qty }}')"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 disabled:opacity-40 disabled:cursor-not-allowed">
                                                <span class="sr-only">Increase</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 4a1 1 0 011 1v4h4a1 1 0 110 2h-4v4a1 1 0 11-2 0v-4H5a1 1 0 110-2h4V5a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                                            </button>
                                        </div>

                                        @if($item->cycle && $item->cycle->count() > 0 && $item->cycle->first() !== 'one_time' && ($item->productType ?? null) !== 'OnlineServicesNCE')
                                            <div class="min-w-[10rem]">
                                                <label class="sr-only">Billing cycle</label>
                                                <select class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                                    wire:change="changeBilling($event.target.value, '{{ $item->id }}')">
                                                    <option value="" selected hidden>{{ ucfirst($item->billing_cycle) }}</option>
                                                    @foreach($item->cycle as $cycle)
                                                        <option value="{{ $cycle }}">{{ ucfirst($cycle) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>

                                    @error('qty')
                                        <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                                    @enderror
                                    @error('billing_cycle')
                                        <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        @if(auth()->user()->userLevel->name !== 'Customer')
                            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4">
                                <label class="block text-sm font-semibold text-slate-900">Customer</label>
                                <p class="mt-1 text-sm text-slate-600">Select who you are purchasing for.</p>
                                <select wire:model="company_name" wire:change="setCustomer($event.target.value, '')"
                                    class="mt-3 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <option value="" selected hidden>{{ ucwords(trans_choice('messages.select_one', 1)) }}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('company_name')
                                    <p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                    @else
                        <div class="flex h-full items-center justify-center">
                            <div class="text-center">
                                <div class="text-base font-semibold text-slate-900">Your cart is empty</div>
                                <div class="mt-1 text-sm text-slate-600">Browse the store and add some products.</div>
                                <a href="{{ route('store.index') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Return to store</a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Summary (sticky bottom) -->
                <div class="sticky bottom-0 border-t border-slate-200 bg-white px-6 py-5">
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-semibold text-slate-900">{{ number_format((float)($totalCartWithoutTax ?? 0), 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Taxes</span>
                            <span class="text-slate-600">Calculated later</span>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-2">
                        @php
                            $cta = ($cartNeedsTenant && !$tenantVerified)
                                ? 'Verify tenant to checkout'
                                : 'Continue to checkout';
                        @endphp
                        <button type="button" wire:click="checkout"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-primary-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                            {{ $cta }}
                        </button>

                        <a href="{{ route('cart.index') }}" class="inline-flex w-full items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            View cart
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

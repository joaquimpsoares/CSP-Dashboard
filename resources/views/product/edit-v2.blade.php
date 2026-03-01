<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Edit product</h2>
                <p class="mt-1 text-sm text-slate-600">
                    Update catalog metadata. SKU and vendor are typically sourced from Partner Center and should stay stable.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('product.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <div class="font-semibold">Please fix the errors below:</div>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Main form -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h3 class="text-base font-semibold text-slate-900">Product details</h3>
                            <p class="mt-1 text-sm text-slate-600">Fields that control how the product is presented and constrained in orders.</p>
                        </div>

                        <form method="POST" action="{{ route('product.update', $product) }}" class="px-6 py-6">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700" for="name">Name</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" required>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700" for="description">Description</label>
                                    <textarea id="description" name="description" rows="4"
                                              class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="category">Category</label>
                                    <input id="category" name="category" type="text" value="{{ old('category', $product->category) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="billing">Billing</label>
                                    <input id="billing" name="billing" type="text" value="{{ old('billing', $product->billing) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="minimum_quantity">Minimum quantity</label>
                                    <input id="minimum_quantity" name="minimum_quantity" type="number" min="0" value="{{ old('minimum_quantity', $product->minimum_quantity) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="maximum_quantity">Maximum quantity</label>
                                    <input id="maximum_quantity" name="maximum_quantity" type="number" min="0" value="{{ old('maximum_quantity', $product->maximum_quantity) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700" for="limit">Limit</label>
                                    <input id="limit" name="limit" type="number" min="0" value="{{ old('limit', $product->limit) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700" for="supported_billing_cycles">Supported billing cycles</label>
                                    <input id="supported_billing_cycles" name="supported_billing_cycles" type="text"
                                           value="{{ old('supported_billing_cycles', is_array($supportedBillingCycles ?? null) ? implode(',', $supportedBillingCycles) : ($product->supported_billing_cycles ?? '')) }}"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20"
                                           placeholder="monthly,annual">
                                    <p class="mt-1 text-xs text-slate-500">Comma-separated. Stored as JSON internally.</p>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-200 pt-6">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h3 class="text-base font-semibold text-slate-900">Identity</h3>
                            <p class="mt-1 text-sm text-slate-600">Source identifiers.</p>
                        </div>
                        <div class="space-y-3 px-6 py-6 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">ID</span>
                                <span class="font-medium text-slate-900">{{ $product->id }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">Vendor</span>
                                <span class="font-medium text-slate-900">{{ $product->vendor ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">SKU</span>
                                <span class="font-mono text-xs font-semibold text-slate-900">{{ $product->sku ?? '—' }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-slate-500">Instance</span>
                                <span class="font-medium text-slate-900">{{ $product->instance->name ?? $product->instance_id ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                        <div class="border-b border-slate-200 px-6 py-4">
                            <h3 class="text-base font-semibold text-slate-900">Quick links</h3>
                        </div>
                        <div class="px-6 py-6">
                            <a href="{{ route('product.show', $product->id) }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">View product</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

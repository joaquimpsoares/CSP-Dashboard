<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Pricing</h2>
            <p class="mt-1 text-sm text-slate-600">Manage price lists, rules, and test quotes with full explainability.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <a href="{{ route('pricing.rules') }}" class="rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm hover:bg-white">
                    <div class="text-sm font-semibold text-slate-900">Rules</div>
                    <div class="mt-1 text-sm text-slate-600">Create markup/discount/fixed pricing rules.</div>
                </a>
                <a href="{{ route('pricing.simulator') }}" class="rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm hover:bg-white">
                    <div class="text-sm font-semibold text-slate-900">Simulator</div>
                    <div class="mt-1 text-sm text-slate-600">Quote a line and open “Why this price”.</div>
                </a>
                <div class="rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm">
                    <div class="text-sm font-semibold text-slate-900">Microsoft import</div>
                    <div class="mt-1 text-sm text-slate-600">Import pricing and normalize catalog.</div>

                    <form method="POST" action="{{ route('pricing.import.microsoft') }}" class="mt-4 flex flex-col gap-3">
                        @csrf
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Market</label>
                                <input name="market" value="ES" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" />
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-600">Currency</label>
                                <input name="currency" value="EUR" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" />
                            </div>
                        </div>

                        <button type="submit" class="rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white hover:bg-primary-700">Import from Microsoft</button>
                    </form>

                    <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-3">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">Catalog</div>
                            <div class="mt-1 text-sm text-slate-600">Normalize category/product family on latest price list.</div>
                        </div>
                        <form method="POST" action="{{ route('pricing.normalize') }}">
                            @csrf
                            <button type="submit" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Normalize</button>
                        </form>
                    </div>
                    <div class="mt-3 text-xs text-slate-500">Categories: licenses, azure, perpetual</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

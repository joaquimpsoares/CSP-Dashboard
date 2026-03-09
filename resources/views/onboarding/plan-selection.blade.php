<x-onboarding.layout title="Choose your plan" :step="3">

    <div x-data="{
        currency: 'eur',
        interval: 'monthly',
        plans: @json($plans)
    }">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-8 mb-6">
            <h1 class="text-xl font-semibold text-slate-900">Choose your plan</h1>
            <p class="mt-1 text-sm text-slate-500">14-day free trial — no credit card required to start.</p>

            <!-- Currency + Interval toggles -->
            <div class="mt-5 flex flex-wrap items-center gap-4">
                <div class="flex rounded-lg border border-slate-200 overflow-hidden text-sm font-medium">
                    <button type="button" @click="currency='eur'"
                            :class="currency==='eur' ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50'"
                            class="px-4 py-1.5 transition">EUR €</button>
                    <button type="button" @click="currency='usd'"
                            :class="currency==='usd' ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50'"
                            class="px-4 py-1.5 transition">USD $</button>
                </div>
                <div class="flex rounded-lg border border-slate-200 overflow-hidden text-sm font-medium">
                    <button type="button" @click="interval='monthly'"
                            :class="interval==='monthly' ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50'"
                            class="px-4 py-1.5 transition">Monthly</button>
                    <button type="button" @click="interval='annual'"
                            :class="interval==='annual' ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50'"
                            class="px-4 py-1.5 transition">Annual</button>
                    <button type="button" @click="interval='usage'"
                            :class="interval==='usage' ? 'bg-primary-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50'"
                            class="px-4 py-1.5 transition">Usage</button>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Plan cards -->
        <div class="grid grid-cols-1 gap-4">
            @foreach($plans as $key => $plan)
            <div class="relative rounded-2xl border {{ $key === 'growth' ? 'border-primary-400 ring-2 ring-primary-400' : 'border-slate-200' }} bg-white shadow-sm p-6">

                @if($key === 'growth')
                    <span class="absolute -top-3 left-6 inline-flex items-center rounded-full bg-primary-600 px-3 py-0.5 text-xs font-semibold text-white">Most Popular</span>
                @endif

                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">{{ $plan['name'] }}</h2>
                        <p class="mt-0.5 text-xs text-slate-500">{{ $plan['description'] }}</p>
                    </div>
                    <div class="text-right">
                        <template x-if="plans['{{ $key }}'].prices[currency][interval]">
                            <span class="text-xs text-slate-400" x-text="'Price ID: ' + plans['{{ $key }}'].prices[currency][interval].slice(-8) + '…'"></span>
                        </template>
                        <template x-if="!plans['{{ $key }}'].prices[currency][interval]">
                            <span class="text-xs text-rose-500">Not available</span>
                        </template>
                    </div>
                </div>

                <ul class="mt-4 space-y-1.5">
                    @foreach($plan['features'] as $feature)
                        <li class="flex items-center gap-2 text-sm text-slate-700">
                            <span class="flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">✓</span>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('onboarding.checkout') }}" class="mt-5">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $key }}">
                    <input type="hidden" name="currency" :value="currency">
                    <input type="hidden" name="interval" :value="interval">

                    <button type="submit"
                            :disabled="!plans['{{ $key }}'].prices[currency][interval]"
                            :class="!plans['{{ $key }}'].prices[currency][interval] ? 'opacity-40 cursor-not-allowed bg-slate-300 text-slate-600' : '{{ $key === 'growth' ? 'bg-primary-600 hover:bg-primary-700 text-white' : 'bg-slate-800 hover:bg-slate-900 text-white' }}'"
                            class="w-full rounded-lg px-4 py-2.5 text-sm font-semibold shadow-sm focus:outline-none focus:ring-4 focus:ring-primary-500/30 transition">
                        Start free trial
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

</x-onboarding.layout>

<x-onboarding.layout title="Partner type" :step="2">

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm p-8">
        <h1 class="text-xl font-semibold text-slate-900">What type of Microsoft CSP partner are you?</h1>
        <p class="mt-2 text-sm text-slate-600">This determines how your resellers and customers are structured.</p>

        @if($errors->any())
            <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('onboarding.type.save') }}" class="mt-6"
              x-data="{ selected: '{{ old('type') }}' }">
            @csrf

            <input type="hidden" name="type" :value="selected">

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- Direct Provider -->
                <button type="button"
                        @click="selected = 'direct'"
                        :class="selected === 'direct'
                            ? 'border-primary-500 ring-2 ring-primary-500 bg-primary-50'
                            : 'border-slate-200 hover:border-slate-300'"
                        class="relative flex flex-col items-start rounded-xl border-2 p-5 text-left transition">
                    <div class="flex w-full items-start justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span x-show="selected === 'direct'"
                              class="flex h-5 w-5 items-center justify-center rounded-full bg-primary-600 text-white text-xs font-bold">✓</span>
                    </div>
                    <div class="mt-3">
                        <div class="text-sm font-semibold text-slate-900">Direct Provider</div>
                        <div class="mt-1 text-xs text-slate-500">I sell Microsoft subscriptions directly to my customers</div>
                    </div>
                </button>

                <!-- Indirect Provider -->
                <button type="button"
                        @click="selected = 'indirect'"
                        :class="selected === 'indirect'
                            ? 'border-primary-500 ring-2 ring-primary-500 bg-primary-50'
                            : 'border-slate-200 hover:border-slate-300'"
                        class="relative flex flex-col items-start rounded-xl border-2 p-5 text-left transition">
                    <div class="flex w-full items-start justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span x-show="selected === 'indirect'"
                              class="flex h-5 w-5 items-center justify-center rounded-full bg-primary-600 text-white text-xs font-bold">✓</span>
                    </div>
                    <div class="mt-3">
                        <div class="text-sm font-semibold text-slate-900">Indirect Provider</div>
                        <div class="mt-1 text-xs text-slate-500">I manage resellers who sell to end customers</div>
                    </div>
                </button>
            </div>

            <button type="submit"
                    :disabled="!selected"
                    :class="!selected ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary-700'"
                    class="mt-6 w-full rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm focus:outline-none focus:ring-4 focus:ring-primary-500/30 transition">
                Continue
            </button>
        </form>
    </div>

</x-onboarding.layout>

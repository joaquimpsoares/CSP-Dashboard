<x-onboarding.layout title="You're all set!">

    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 shadow-sm p-8 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-3xl font-bold">
            ✓
        </div>
        <h1 class="mt-4 text-xl font-semibold text-slate-900">You're all set!</h1>
        <p class="mt-2 text-sm text-slate-600">Your 14-day trial has started. Complete your setup to start managing subscriptions.</p>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm p-6">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">Next steps</h2>
        <div class="space-y-3">
            @php
            $steps = [
                ['done' => true,  'label' => 'Email verified'],
                ['done' => true,  'label' => 'Partner type selected'],
                ['done' => true,  'label' => 'Plan selected'],
                ['done' => false, 'label' => 'Connect Microsoft Partner Center', 'link' => route('instances.index')],
                ['done' => false, 'label' => 'Add your first customer', 'link' => route('customer.index')],
            ];
            @endphp

            @foreach($steps as $step)
                <div class="flex items-center gap-3">
                    @if($step['done'])
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-xs font-bold">✓</span>
                        <span class="text-sm text-slate-400 line-through">{{ $step['label'] }}</span>
                    @else
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 text-slate-400 text-xs">○</span>
                        @if(isset($step['link']))
                            <a href="{{ $step['link'] }}" class="text-sm font-medium text-primary-700 hover:text-primary-900">
                                {{ $step['label'] }} →
                            </a>
                        @else
                            <span class="text-sm text-slate-700">{{ $step['label'] }}</span>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('dashboard') }}"
           class="block w-full rounded-lg bg-primary-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30 transition">
            Go to Dashboard
        </a>
    </div>

</x-onboarding.layout>

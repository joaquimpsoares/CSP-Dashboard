
@props(['id' => null, 'maxWidth' => null, 'closeOnBackdrop' => true])
<x-slideout :id="$id" :maxWidth="$maxWidth" :closeOnBackdrop="$closeOnBackdrop" {{ $attributes }}>
    <div class="flex h-full flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-base font-semibold text-slate-900" id="slide-over-title">{{ $title }}</h2>
                <p class="mt-0.5 text-xs text-slate-600">Make changes and save.</p>
            </div>
            <button wire:click="$set('showEditModal', false)" type="button"
                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                <span class="sr-only">Close panel</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto bg-[#f6f9fc] px-6 py-6">
            <div class="rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm">
                {{ $content }}
            </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-white px-6 py-4">
            {{ $footer }}
        </div>
    </div>
</x-slideout>

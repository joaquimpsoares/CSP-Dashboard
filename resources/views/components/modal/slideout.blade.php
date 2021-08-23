
@props(['id' => null, 'maxWidth' => null])

<x-slideout :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="flex-1 h-0 overflow-y-auto">
        <div class="px-4 py-6 bg-indigo-700 sm:px-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-medium text-white" id="slide-over-title">
                    {{ $title }}
                </h2>
                <div class="flex items-center ml-3 h-7">
                    <button wire:click="$set('showEditModal', false)" type="button" class="text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                        <span class="sr-only">Close panel</span>
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex flex-col justify-between flex-1">
            <div class="px-4 divide-y divide-gray-200 sm:px-6">
                <div class="pt-6 pb-5 space-y-6">
                    {{ $content }}
                </div>
            </div>
        </div>

        <div class="px-6 py-4 text-right bg-gray-100">
            {{ $footer }}
        </div>
    </div>
</x-slideout>

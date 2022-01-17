
@props(['id' => null, 'maxWidth' => null])
<x-slideout :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="flex flex-col h-full divide-y divide-gray-200 shadow-xl">
        <div class="flex flex-col flex-1 min-h-0 py-6 overflow-y-scroll">
            <div class="px-4 sm:px-6">
                <div class="flex items-start justify-between">
                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                        {{ $title }}
                    </h2>
                    <div class="flex items-center ml-3 h-7">
                        <button wire:click="$set('showEditModal', false)" type="button" class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <span class="sr-only">Close panel</span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="relative flex-1 px-4 mt-6 sm:px-6">
                {{ $content }}
            </div>
        </div>
        <div class="flex justify-end flex-shrink-0 px-4 py-4">
            {{ $footer }}

        </div>
    </div>
</x-slideout>

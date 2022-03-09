@auth
<div x-data="{ GlobalSearch: false }" x-on:keydown.escape="GlobalSearch = false" class="relative my-32">
    <button @click="GlobalSearch = !GlobalSearch" class="p-2 bg-white rounded-md relativeblock focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>
    <div x-cloak x-show="GlobalSearch" class="absolute right-0 z-20 mt-2 overflow-hidden bg-white rounded-md shadow-lg" style="width:20rem;">
        <div>
            <div id="headlessui-portal-root"><div>
                <div class="fixed inset-0 z-10 p-4 overflow-y-auto sm:p-6 md:p-20" id="headlessui-dialog-57" role="dialog" aria-modal="rue">
                    <div class="fixed inset-0 transition-opacity bg-opacity-25" id="headlessui-dialog-overlay-59" aria-hidden="true">
                    </div>
                    <div class="max-w-xl mx-auto mt-24 overflow-hidden transition-all transform bg-white shadow-2xl rounded-xl ring-1 ring-black ring-opacity-5">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" view    Box="0 0 20 20" fill="currentColor" class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd">
                                </path>
                            </svg>
                            <input wire:model.debounce.300ms="keyword" class="w-full h-12 pr-4 text-gray-800 placeholder-gray-400 bg-transparent border-0 pl-11 focus:ring-0 sm:text-sm" placeholder="Search..." id="headlessui-combobox-input-61" role="combobox" type="text" aria-expanded="true" value="">
                        </div>
                        @if(isset($searchproduct))
                        <ul class="pb-2 space-y-2 overflow-y-auto max-h-80 scroll-pt-11 scroll-pb-2" role="listbox" id="headlessui-combobox-options-90" aria-activedescendant="headlessui-combobox-option-91">
                            <li role="none">
                                @forelse($searchproduct->groupByType() as $type => $modelSearchResults)
                                <h2 class="bg-gray-100 py-2.5 px-4 text-xs font-semibold text-gray-900" role="none">
                                    {{$type}} ({{$modelSearchResults->count()}})
                                </h2>
                                @forelse ($modelSearchResults as $index => $item)
                                <ul class="mt-2 text-sm text-gray-800" role="none">
                                    <a href="{{ $item->url }}">
                                    <li class="px-4 py-2 text-gray-800 cursor-default select-none hover:bg-gray-100" id="headlessui-combobox-option-91" role="option" tabindex="-1">
                                            {{ $item->title }}
                                        </li>
                                    </a>
                                </ul>
                                @empty
                                <div class="px-6 text-sm text-center border-t border-gray-100 py-14 sm:px-14">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mx-auto text-gray-400" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-4 font-semibold text-gray-900">
                                        No results found
                                    </p>
                                    <p class="mt-2 text-gray-500">
                                        We couldn’t find anything with that term. Please try again.
                                    </p>
                                    @endforelse
                                </li>
                            </ul>
                            @empty
                            <div class="px-6 text-sm text-center border-t border-gray-100 py-14 sm:px-14">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 mx-auto text-gray-400" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="mt-4 font-semibold text-gray-900">
                                    No results found
                                </p>
                                <p class="mt-2 text-gray-500">
                                    We couldn’t find anything with that term. Please try again.
                                </p>
                            </div>
                            @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endauth

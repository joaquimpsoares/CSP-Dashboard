@auth
<div x-data="{ GlobalSearch: false }" @keydown.escape.window="GlobalSearch = false" class="inline-block">
    <button type="button" @click="GlobalSearch = true; $nextTick(() => $refs.input.focus());" class="p-2 bg-white rounded-md relative block focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>
    <div x-cloak x-show="GlobalSearch" class="fixed inset-0 z-50" aria-modal="true" role="dialog">
        <!-- Backdrop -->
        <button type="button" class="absolute inset-0 bg-black/20" @click="GlobalSearch = false"></button>

        <div class="relative mx-auto mt-24 w-full max-w-xl px-4">
            <div class="overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                <div class="relative border-b border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-slate-400" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>

                    <input
                        x-ref="input"
                        wire:model.debounce.300ms="keyword"
                        @keydown.enter.prevent="GlobalSearch = false"
                        class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0"
                        placeholder="Search..."
                        type="text"
                        autofocus
                    >
                </div>
                @if(isset($searchproduct))
                    <div class="max-h-80 overflow-y-auto py-2">
                        @forelse($searchproduct->groupByType() as $type => $modelSearchResults)
                            <div class="px-4 pb-2 pt-3 text-xs font-semibold uppercase tracking-wide text-slate-600">
                                {{$type}} ({{$modelSearchResults->count()}})
                            </div>

                            @forelse ($modelSearchResults as $index => $item)
                                <a href="{{ $item->url }}" @click="GlobalSearch = false" class="block px-4 py-2 text-sm text-slate-800 hover:bg-slate-50">
                                    {{ $item->title }}
                                </a>
                            @empty
                                <div class="px-4 py-6 text-center text-sm text-slate-600">No results.</div>
                            @endforelse
                        @empty
                            <div class="px-4 py-6 text-center text-sm text-slate-600">No results found.</div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endauth

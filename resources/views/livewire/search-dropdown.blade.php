<div>
    <div
    x-data="{
        open: @entangle('showDropdown'),
        search: @entangle('search'),
        selected: @entangle('selected'),
        highlightedIndex: 0,
        highlightPrevious() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex = this.highlightedIndex - 1;
                this.scrollIntoView();
            }
        },
        highlightNext() {
            if (this.highlightedIndex < this.$refs.results.children.length - 1) {
                this.highlightedIndex = this.highlightedIndex + 1;
                this.scrollIntoView();
            }
        },
        scrollIntoView() {
            this.$refs.results.children[this.highlightedIndex].scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
        },
        updateSelected(id, name) {
            this.selected = id;
            this.search = name;
            this.open = false;
            this.highlightedIndex = 0;
        },
    }">
    <div x-on:value-selected="updateSelected($event.detail.id, $event.detail.name)">
        <label for="search" >Search</label>
        <div class="relative text-gray-400 focus-within:text-gray-500">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <!-- Heroicon name: solid/search -->
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input
            wire:model.debounce.300ms="search"
            x-on:keydown.arrow-down.stop.prevent="highlightNext()"
            x-on:keydown.arrow-up.stop.prevent="highlightPrevious()"
            x-on:keydown.enter.stop.prevent="$dispatch('value-selected', {
                id: $refs.results.children[highlightedIndex].getAttribute('data-result-id'),
                name: $refs.results.children[highlightedIndex].getAttribute('data-result-name')
            })" placeholder="sku" type="search" name="sku"  class="@error('editing.sku') is-invalid @enderror block w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-9 sm:text-sm">
            @error('editing.sku')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>

        <div
        x-show="open"
        x-on:click.away="open = false">
        <ul x-ref="results">
            @forelse($results as $index => $result)
            <li
            wire:key="{{ $index }}"
            x-on:click.stop="$dispatch('value-selected', {
                id: {{ $result->id }},
                name: '{{ $result->name }}'
            })"
            :class="{
                'bg-indigo-400': {{ $index }} === highlightedIndex,
                'text-white': {{ $index }} === highlightedIndex
            }"
            data-result-id="{{ $result->id }}"
            data-result-name="{{ $result->name }}">
            <span>
                {{ $result->name }}
            </span>
        </li>
        @empty
        <li>No results found</li>
        @endforelse
    </ul>
</div>
</div>
</div>
</div>

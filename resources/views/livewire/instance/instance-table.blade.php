<div>
    <div class="relative z-0 flex-col flex-1 overflow-visible">
        <div class="p-6 bg-transparent">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between gap-3 lg:flex-row">
                    <div class="flex items-center">
                        <h4 class="text-base font-semibold text-slate-900">{{ ucwords(trans_choice('messages.instance', 2)) }}</h4>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div class="flex justify-center flex-1 lg:justify-end">
                            <div class="w-full max-w-lg lg:max-w-xs">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative text-gray-400 focus-within:text-gray-500">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input wire:model.live="search" id="search" class="block w-full bg-white py-2 pl-10 pr-3 border border-slate-300 rounded-lg leading-5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 sm:text-sm" placeholder="Search instances" type="search" name="search">
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('provider.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Create instance
                            </a>
                        </div>
                    </div>
                </div>

                <x-tableazure>
                    <x-slot name="head">
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.id', 2)) }}</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('type')" :direction="$sorts['type'] ?? null">{{ ucwords(trans_choice('messages.type', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell'>Provider</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('expires_at')" :direction="$sorts['expires_at'] ?? null">Expires</x-table.heading>
                    </x-slot>

                    <x-slot name="body">
                        @forelse ($instances as $instance)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-instance-{{ $instance->id }}">
                                <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                    <a href="{{ route('instances.edit', $instance->id) }}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $instance->id }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>

                                <x-table.cell>
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                        <a href="{{ route('instances.edit', $instance->id) }}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                    {{ $instance->name }}
                                                </span>
                                                @if(method_exists($instance, 'isExpired') && $instance->isExpired())
                                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">Expired</span>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </x-table.cell>

                                <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                    <a href="{{ route('instances.edit', $instance->id) }}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                            <span class="text-sm font-medium text-slate-700">{{ $instance->type ?? '—' }}</span>
                                            @if(!empty($instance->external_type))
                                                <div class="text-xs text-slate-500">{{ $instance->external_type }}</div>
                                            @endif
                                        </div>
                                    </a>
                                </x-table.cell>

                                <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                    <a href="{{ route('instances.edit', $instance->id) }}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                            <span class="text-sm font-medium text-slate-700">{{ $instance->provider->company_name ?? $instance->provider->name ?? '—' }}</span>
                                        </div>
                                    </a>
                                </x-table.cell>

                                <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                    <a href="{{ route('instances.edit', $instance->id) }}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                            <span class="text-sm text-slate-700">{{ optional($instance->expires_at)->format('Y-m-d') ?? '—' }}</span>
                                        </div>
                                    </a>
                                </x-table.cell>

                                <x-table.cell class="text-right">
                                    <div x-data="{
                                            open: false,
                                            top: 0,
                                            left: 0,
                                            width: 0,
                                            place() {
                                                const r = this.$refs.btn.getBoundingClientRect();
                                                this.width = 192;
                                                this.top = r.bottom + 8;
                                                this.left = Math.max(8, r.right - this.width);
                                            },
                                            toggle() {
                                                this.open = !this.open;
                                                if (this.open) this.$nextTick(() => this.place());
                                            }
                                        }"
                                        @keydown.escape.window="open = false"
                                        class="inline-block">

                                        <button type="button" x-ref="btn" @click="toggle()"
                                            class="inline-flex items-center justify-center rounded-lg px-2 py-2 text-slate-600 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                            aria-haspopup="true">
                                            <span class="sr-only">Open actions</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>

                                        <template x-teleport="body">
                                            <div x-cloak x-show="open" @click.away="open = false" @scroll.window="open = false" @resize.window="open = false"
                                                class="fixed z-[9999] w-48 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
                                                :style="`top:${top}px; left:${left}px;`">

                                                <a href="{{ route('instances.edit', $instance->id) }}"
                                                   class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                    <x-icon.edit></x-icon.edit>
                                                    <span>Edit</span>
                                                </a>

                                                @if(($instance->type ?? '') === 'Microsoft')
                                                    <a href="{{ route('instances.getMasterToken', $instance->id) }}"
                                                       class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                        <x-icon.refresh></x-icon.refresh>
                                                        <span>Refresh master token</span>
                                                    </a>
                                                @endif
                                            </div>
                                        </template>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @empty
                            <x-table.row>
                                <x-table.cell colspan="9">
                                    <div class="flex items-center justify-center space-x-2">
                                        <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No instances found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                        @endforelse
                    </x-slot>
                </x-tableazure>

                <div>
                    {{ $instances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
